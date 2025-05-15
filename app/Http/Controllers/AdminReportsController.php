<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function showReports()
    {
        return view('admin.reports');
    }
} 