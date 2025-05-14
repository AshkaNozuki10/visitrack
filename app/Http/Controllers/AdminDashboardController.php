<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Appointment;
use App\Models\Building;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Get all records from the tracking log
        $records = DB::table('student_tracking_log')
            ->orderBy('created_at', 'desc')
            ->get();

        // Filter active students (those without exit time)
        $activeStudents = $records->filter(function ($record) {
            return empty($record->exit_time);
        })->values();

        // Get counts for dashboard
        $activeStudentsCount = $activeStudents->count();
        $pendingAppointmentsCount = Appointment::whereNull('approval')->count();
        $approvedAppointmentsCount = Appointment::where('approval', 'approved')->count();
        $buildingsCount = Building::count();

        // Get recent activities (combining appointments and tracking logs)
        $recentActivities = collect();
        
        // Add recent appointments
        $recentAppointments = Appointment::with(['user', 'visit'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($appointment) {
                return (object)[
                    'type' => 'appointment',
                    'title' => 'New Appointment Request',
                    'description' => "{$appointment->user->name} requested to visit {$appointment->visit->building_name}",
                    'created_at' => $appointment->created_at
                ];
            });
        
        // Add recent tracking logs
        $recentTrackingLogs = DB::table('student_tracking_log')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(function ($log) {
                return (object)[
                    'type' => 'tracking',
                    'title' => 'Visitor Movement',
                    'description' => "Visitor entered {$log->building_name}",
                    'created_at' => $log->created_at
                ];
            });

        // Combine and sort by created_at
        $recentActivities = $recentAppointments->concat($recentTrackingLogs)
            ->sortByDesc('created_at')
            ->take(5);

        return view('admin.admin_dashboard', [
            'records' => $records,
            'activeStudents' => $activeStudents,
            'activeStudentsCount' => $activeStudentsCount,
            'pendingAppointmentsCount' => $pendingAppointmentsCount,
            'approvedAppointmentsCount' => $approvedAppointmentsCount,
            'buildingsCount' => $buildingsCount,
            'recentActivities' => $recentActivities
        ]);
    }

    public function pendingAppointmentsForAdmin()
    {
        $appointments = \App\Models\Appointment::whereNull('approval')->with(['visit', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.adminpending', compact('appointments'));
    }
} 
