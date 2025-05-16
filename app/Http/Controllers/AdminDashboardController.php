<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Building;
use App\Models\Visit;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with summary statistics and recent activities.
     */
    public function dashboard(){
        $records = Visit::all();
        return view('admin.admin_dashboard', compact('records'));

        $activeStudents = []; // Or fetch active students from your database
        $activeStudentsCount = 0; // Or count of active students

        // Get counts for dashboard
        $activeStudentsCount = DB::table('visit')->whereNull('exit_time')->count();
        $pendingAppointmentsCount = Appointment::whereNull('approval')->count();
        $approvedAppointmentsCount = Appointment::where('approval', 'approved')->count();
        $buildingsCount = Building::count();

        // Get recent activities (appointments and tracking logs)
        $recentAppointments = Appointment::with(['user', 'visit'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($appointment) {
                return (object)[
                    'type' => 'appointment',
                    'title' => 'New Appointment Request',
                    'description' => ($appointment->user ? $appointment->user->name : 'Unknown user') .
                        ' requested to visit ' . ($appointment->visit ? $appointment->visit->building_name : 'Unknown building'),
                    'created_at' => $appointment->created_at
                ];
            });

        $records = DB::table('visit')
        ->orderBy('entry_time', 'desc')
        ->get()
        ->map(function ($record) {
            // Calculate duration in minutes if exit_time exists
            $duration = null;
            if ($record->entry_time && $record->exit_time) {
                $duration = round((strtotime($record->exit_time) - strtotime($record->entry_time)) / 60);
            }
            return [
                'user_id' => $record->user_id,
                'entry_time' => $record->entry_time,
                'exit_time' => $record->exit_time,
                'building_name' => $record->building_name,
                'latitude' => $record->latitude,
                'longitude' => $record->longitude,
                'duration_minutes' => $duration,
            ];
        });

        $recentTrackingLogs = DB::table('visit')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($log) {
                return (object)[
                    'type' => 'tracking',
                    'title' => 'Visitor Movement',
                    'description' => 'Visitor entered ' . ($log->building_name ?? 'Unknown building'),
                    'created_at' => $log->created_at
                ];
            });

        $recentActivities = $recentAppointments->concat($recentTrackingLogs)
            ->sortByDesc('created_at')
            ->take(5);

        return view('admin.admin_dashboard', [
            'activeStudentsCount' => $activeStudentsCount,
            'activeStudents' => $activeStudents,
            'pendingAppointmentsCount' => $pendingAppointmentsCount,
            'approvedAppointmentsCount' => $approvedAppointmentsCount,
            'buildingsCount' => $buildingsCount,
            'recentActivities' => $recentActivities,
            'records' => $records ?? collect(), // Always pass $records, default to empty collection if not set
        ]);
    }

    /**
     * Show the visitor tracking log for admin.
     */
    public function visitorTracking()
    {
        $records = DB::table('visit')
            ->orderBy('created_at', 'desc')
            ->get();
        $activeStudents = $records->filter(function ($record) {
            return empty($record->exit_time);
        })->values();
        return view('admin.visitor_tracking', [
            'records' => $records,
            'activeStudents' => $activeStudents
        ]);
    }

    /**
     * Show all approved appointments for admin.
     */
    public function approvedAppointments()
    {
        $appointments = Appointment::where('approval', 'approved')->with(['visit', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.appointments.admin_approved', compact('appointments'));
    }

    /**
     * Show all rejected appointments for admin.
     */
    public function rejectedAppointments()
    {
        $appointments = Appointment::where('approval', 'rejected')->with(['visit', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.appointments.admin_rejected', compact('appointments'));
    }

    /**
     * Show all pending appointments for admin.
     */
    public function pendingAppointments()
    {
        $appointments = Appointment::whereNull('approval')->with(['visit', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.appointments.admin_pending', compact('appointments'));
    }

    /**
     * Show admin reports page.
     */
    public function reports()
    {
        // Add logic for reports as needed
        return view('admin.reports');
    }

    /**
     * Show admin settings page.
     */
    public function settings()
    {
        // Add logic for settings as needed
        return view('admin.settings');
    }
}
