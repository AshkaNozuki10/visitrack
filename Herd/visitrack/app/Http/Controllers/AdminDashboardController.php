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

        return view('admin_dashboard', [
            'records' => $records,
            'activeStudents' => $activeStudents
        ]);
    }
} 