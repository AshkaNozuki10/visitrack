<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        return view('admin.admin_dashboard', [
            'records' => $records,
            'activeStudents' => $activeStudents
        ]);
    }

    public function pendingAppointmentsForAdmin()
    {
        $appointments = \App\Models\Appointment::whereNull('approval')->with(['visit', 'user'])->orderBy('created_at', 'desc')->get();
        return view('admin.adminpending', compact('appointments'));
    }
} 
