<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Visit;

class AdminDashboardController extends Controller
{
   public function dashboard()
{
    // Example: Fetch records from your model
    $records = Visit::with('user')
        ->orderByDesc('created_at')
        ->get()
        ->map(function ($visitor){
            return [
                'user_id'        => $visitor->user->user_id,
                'entry_time'        => $visitor->entry_time,
                'exit_time'         => $visitor->exit_time,
                'building_name'     => $visitor->building_name,
                'latitude'          => $visitor->latitude,
                'longitude'         => $visitor->longitude,
                'duration_minutes'  => $visitor->duration_minutes,
            ];
        });

        // For map markers, you might want only currently active visitors
        $activeStudents = $records->whereNull('exit_time')->values();

        return view('admin_dashboard', [
            'records' => $records,
            'activeStudents' => $activeStudents,
        ]);
    }
}
