<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\House;
use App\Models\Visitor;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\EmergencyAlert;
use App\Models\SecurityLog;
use App\Models\Notice;
use App\Models\User;
<<<<<<< HEAD
=======
use App\Models\Expense;
use App\Models\Staff;
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_residents' => Resident::where('status', 'active')->count(),
            'total_houses' => House::count(),
            'occupied_houses' => House::where('status', 'occupied')->count(),
            'vacant_houses' => House::where('status', 'vacant')->count(),
            'total_visitors_today' => Visitor::whereDate('created_at', today())->count(),
            'total_visitors' => Visitor::count(),
            'open_complaints' => Complaint::where('status', 'pending')->count(),
            'total_complaints' => Complaint::count(),
            'pending_maintenance' => MaintenanceRequest::where('status', 'pending')->count(),
            'total_maintenance' => MaintenanceRequest::count(),
            'active_alerts' => EmergencyAlert::where('status', 'active')->count(),
            'total_users' => User::count(),
<<<<<<< HEAD
            'maintenance_collection' => \App\Models\MaintenancePayment::whereMonth('payment_date', now()->month)->sum('amount'),
            'maintenance_dues' => Resident::sum('due_amount'),
            'maintenance_advance' => Resident::sum('advance_balance'),
            'maintenance_defaulters' => Resident::where('due_amount', '>', 0)->count(),
            'maintenance_high_dues' => Resident::where('due_amount', '>=', 10000)->count(),
=======
            'total_expenses_month' => Expense::whereBetween('date', [now()->startOfMonth(), now()->endOfMonth()])->sum('amount'),
            'total_staff' => Staff::where('status', 'active')->count(),
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        ];

        // Monthly complaints chart data (last 6 months)
        $complaintsChart = Complaint::select(
<<<<<<< HEAD
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subMonths(6))
        ->groupBy('year', 'month')
        ->orderBy('year')
        ->orderBy('month')
        ->get();
=======
            DB::raw("MONTH(created_at) as month"),
            DB::raw("YEAR(created_at) as year"),
            DB::raw("COUNT(*) as count")
        )
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy(
                DB::raw("YEAR(created_at)"),
                DB::raw("MONTH(created_at)")
            )
            ->orderBy(
                DB::raw("YEAR(created_at)")
            )
            ->orderBy(
                DB::raw("MONTH(created_at)")
            )
            ->get();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

        // Complaint status distribution
        $complaintStatus = Complaint::select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Recent activities
        $recentComplaints = Complaint::with(['resident.user', 'category'])
            ->latest()->take(5)->get();

        $recentVisitors = Visitor::with('resident.user')
            ->latest()->take(5)->get();

        $recentMaintenance = MaintenanceRequest::with(['resident.user', 'house'])
            ->latest()->take(5)->get();

        $activeAlerts = EmergencyAlert::where('status', 'active')
            ->latest()->take(3)->get();

        $latestNotices = Notice::published()->latest()->take(3)->get();

        return view('admin.dashboard', compact(
<<<<<<< HEAD
            'stats', 'complaintsChart', 'complaintStatus',
            'recentComplaints', 'recentVisitors', 'recentMaintenance',
            'activeAlerts', 'latestNotices'
=======
            'stats',
            'complaintsChart',
            'complaintStatus',
            'recentComplaints',
            'recentVisitors',
            'recentMaintenance',
            'activeAlerts',
            'latestNotices'
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        ));
    }
}
