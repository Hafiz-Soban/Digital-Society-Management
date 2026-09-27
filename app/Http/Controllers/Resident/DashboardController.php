<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\EmergencyAlert;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\Visitor;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $resident->load(['house']);

        // Stats
        $stats = [
            'total_complaints'     => $resident->complaints()->count(),
            'open_complaints'      => $resident->complaints()->where('status', 'pending')->count(),
            'resolved_complaints'  => $resident->complaints()->where('status', 'resolved')->count(),
            'pending_maintenance'  => $resident->maintenanceRequests()->whereIn('status', ['pending', 'assigned'])->count(),
            'total_visitors'       => $resident->visitors()->count(),
            'pending_visitors'     => $resident->visitors()->where('status', 'pending')->count(),
            'unread_notifications' => $user->unreadNotifications()->count(),
        ];

        // Recent data
        $recentComplaints    = $resident->complaints()->with('category')->latest()->take(4)->get();
        $activeMaintenance   = $resident->maintenanceRequests()->with('assignedStaff')
                                ->whereIn('status', ['pending', 'assigned', 'in_progress'])
                                ->latest()->take(4)->get();
        $recentVisitors      = $resident->visitors()->latest()->take(4)->get();
        $notices             = Notice::published()->latest()->take(5)->get();
        $activeAlerts        = EmergencyAlert::where('status', 'active')->latest()->take(3)->get();
        $recentNotifications = $user->notifications()->latest()->take(5)->get();

        return view('resident.dashboard', compact(
            'resident', 'stats', 'recentComplaints', 'activeMaintenance',
            'recentVisitors', 'notices', 'activeAlerts', 'recentNotifications'
        ));
    }
}
