<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Appointment;
use App\Models\Visit;

class SecurityGuardController extends Controller
{
    public function dashboard()
    {
        // Get today's expected visitors
        $expectedVisitors = Appointment::with(['user'])
            ->whereDate('appointment_date', today())
            ->where('approval', 'approved')
            ->get()
            ->map(function ($appointment) {
                return [
                    'name' => $appointment->user->first_name . ' ' . $appointment->user->last_name,
                    'purpose' => $appointment->purpose,
                    'department' => $appointment->department,
                    'expected_time' => $appointment->appointment_time,
                    'status' => $this->getVisitorStatus($appointment->user_id)
                ];
            });

        // Get current visitors
        $currentVisitors = Visit::with(['user'])
            ->whereNull('exit_time')
            ->get()
            ->map(function ($visit) {
                return [
                    'name' => $visit->user->first_name . ' ' . $visit->user->last_name,
                    'check_in_time' => $visit->entry_time,
                    'location' => $visit->location
                ];
            });

        // Get walk-in visitors count for today
        $walkInCount = Visit::whereDate('visit_date', today())
            ->whereNotIn('user_id', function($query) {
                $query->select('user_id')
                    ->from('appointment')
                    ->whereDate('appointment_date', today());
            })
            ->count();

        return view('security.dashboard', compact('expectedVisitors', 'currentVisitors', 'walkInCount'));
    }

    private function getVisitorStatus($userId)
    {
        $visit = Visit::where('user_id', $userId)
            ->whereDate('visit_date', today())
            ->first();

        if (!$visit) {
            return 'Not Arrived';
        }

        if ($visit->exit_time) {
            return 'Checked Out';
        }

        return 'Checked In';
    }

    public function checkIn(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:user,user_id',
            'location' => 'required|exists:location,location_id'
        ]);

        Visit::create([
            'user_id' => $request->user_id,
            'visit_date' => today(),
            'entry_time' => now(),
            'location' => $request->location
        ]);

        return redirect()->back()->with('success', 'Visitor checked in successfully.');
    }

    public function checkOut(Request $request)
    {
        $request->validate([
            'visit_id' => 'required|exists:visit,visit_id'
        ]);

        $visit = Visit::find($request->visit_id);
        $visit->update([
            'exit_time' => now()
        ]);

        return redirect()->back()->with('success', 'Visitor checked out successfully.');
    }
}
