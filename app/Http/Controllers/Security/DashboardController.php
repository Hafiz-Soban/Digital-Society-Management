<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\SecurityLog;
use App\Models\EmergencyAlert;
use App\Models\SecurityIncident;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();

        $stats = [
            'total_visitors_today' => Visitor::whereDate('created_at', $today)->count(),
            'approved_visitors' => Visitor::where('status', 'approved')->whereDate('created_at', $today)->count(),
            'rejected_visitors' => Visitor::where('status', 'denied')->whereDate('created_at', $today)->count(),
            'active_alerts' => EmergencyAlert::where('status', 'active')->count(),
            'emergency_cases' => EmergencyAlert::count(),
            'pending_requests' => Visitor::where('status', 'pending')->count(),
        ];

        $recentVisitors = Visitor::with(['resident.user', 'resident.house'])
            ->latest()
            ->take(10)
            ->get();

        $activeAlerts = EmergencyAlert::where('status', 'active')->latest()->get();

        $recentIncidents = SecurityIncident::with('reporter')
            ->latest()
            ->take(5)
            ->get();

        $recentLogs = SecurityLog::with(['loggedBy', 'visitor'])
            ->latest()
            ->take(10)
            ->get();

        return view('security.dashboard', compact('stats', 'recentVisitors', 'activeAlerts', 'recentIncidents', 'recentLogs'));
    }
}
