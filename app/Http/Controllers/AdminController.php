<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Visit;
use App\Models\User;
use App\Models\Appointment;

class AdminController extends Controller
{
    public function index()
    {
        return view ('admin.admin_dashboard');
        // Get current visitors count
        $currentVisitors = Visit::whereNull('exit_time')->count();
        
        // Get today's visitors count
        $todayVisitors = Visit::whereDate('visit_date', today())->count();
        
        // Get pending approvals count
        $pendingApprovals = Appointment::whereNull('approval')->count();
        
        // Get blacklisted count
        $blocklistedCount = User::where('is_blocklisted', true)->count();
        
        // Get current visitors list with their information
        $currentVisitorsList = Visit::with(['user', 'appointment'])
            ->whereNull('exit_time')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($visit) {
                return [
                    'name' => $visit->user->first_name . ' ' . $visit->user->last_name,
                    'purpose' => $visit->appointment->purpose ?? 'Walk-in',
                    'department' => $visit->appointment->department ?? 'N/A',
                    'check_in_time' => $visit->entry_time,
                    'status' => 'Active'
                ];
            });
        
        // Get recent activity
        $recentActivity = DB::table('activity_logs')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('admin.admin_dashboard', compact(
            'currentVisitors',
            'todayVisitors',
            'pendingApprovals',
            'blocklistedCount',
            'currentVisitorsList',
            'recentActivity'
        ));
    }

    public function visitors()
    {
        $visitors = Visit::with(['user', 'appointment'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.visitor_tracking', compact('visitors'));
    }

    public function reports()
    {
        // Get visitor traffic data for the chart
        $trafficData = Visit::select(
            DB::raw('HOUR(entry_time) as hour'),
            DB::raw('COUNT(*) as count')
        )
        ->whereDate('visit_date', today())
        ->groupBy('hour')
        ->get();
        
        // Get visit duration statistics
        $durationStats = Visit::select(
            DB::raw('AVG(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as avg_duration'),
            DB::raw('MAX(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as max_duration'),
            DB::raw('MIN(TIMESTAMPDIFF(MINUTE, entry_time, exit_time)) as min_duration')
        )
        ->whereNotNull('exit_time')
        ->first();
        
        return view('admin.reports', compact('trafficData', 'durationStats'));
    }

    public function blocklist()
    {
        $blocklisted = User::where('is_blocklisted', true)
            ->with('visits')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
            
        return view('admin.blocklist', compact('blocklisted'));
    }

    public function addToBlocklist(Request $request, User $information)
    {
        $information->update([
            'is_blocklisted' => true,
            'blocklist_reason' => $request->reason
        ]);
        
        return redirect()->back()->with('success', 'Visitor has been blacklisted.');
    }

    public function removeFromBlocklist(User $information)
    {
        $information->update([
            'is_blocklisted' => false,
            'blocklist_reason' => null
        ]);
        
        return redirect()->back()->with('success', 'Visitor has been removed from blocklist.');
    }

    public function checkOut(Visit $visit)
    {
        $visit->update([
            'exit_time' => now()
        ]);
        
        return redirect()->back()->with('success', 'Visitor has been checked out.');
    }
}
