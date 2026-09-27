<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Visitor;
use App\Models\Complaint;
use App\Models\MaintenanceRequest;
use App\Models\SecurityLog;
use App\Models\House;
<<<<<<< HEAD
use App\Models\Staff;
use App\Models\StaffAttendance;
use App\Models\StaffSalary;
use App\Models\StaffAdvance;
use App\Models\ActivityLog;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

<<<<<<< HEAD
    public function staff(Request $request)
    {
        $query = Staff::query();
        if ($request->designation) $query->where('designation', 'like', "%{$request->designation}%");
        if ($request->status) $query->where('status', $request->status);

        $staffMembers = $query->get();
        $designations = Staff::distinct()->pluck('designation');

        return view('admin.reports.staff', compact('staffMembers', 'designations'));
    }

    public function attendance(Request $request)
    {
        $query = StaffAttendance::with('staff');
        if ($request->from) $query->whereDate('date', '>=', $request->from);
        if ($request->to) $query->whereDate('date', '<=', $request->to);
        if ($request->staff_id) $query->where('staff_id', $request->staff_id);

        $attendance = $query->get();
        $staffMembers = Staff::all();

        return view('admin.reports.attendance', compact('attendance', 'staffMembers'));
    }

    public function salaries(Request $request)
    {
        $query = StaffSalary::with('staff');
        if ($request->month) $query->where('month', $request->month);
        if ($request->status) $query->where('status', $request->status);

        $salaries = $query->get();
        
        return view('admin.reports.salaries', compact('salaries'));
    }

    public function advances(Request $request)
    {
        $query = StaffAdvance::with('staff');
        if ($request->from) $query->whereDate('advance_date', '>=', $request->from);
        if ($request->to) $query->whereDate('advance_date', '<=', $request->to);

        $advances = $query->get();

        return view('admin.reports.advances', compact('advances'));
    }

    public function deletedRecords(Request $request)
    {
        $query = ActivityLog::where('action', 'deleted');
        if ($request->from) $query->whereDate('created_at', '>=', $request->from);
        if ($request->to) $query->whereDate('created_at', '<=', $request->to);

        $logs = $query->latest()->get();

        return view('admin.reports.deleted', compact('logs'));
    }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    public function residents(Request $request)
    {
        $query = Resident::with(['user', 'house']);

        if ($request->status) $query->where('status', $request->status);
        if ($request->from) $query->whereDate('created_at', '>=', $request->from);
        if ($request->to) $query->whereDate('created_at', '<=', $request->to);

        $residents = $query->get();

        $stats = [
            'total' => $residents->count(),
            'active' => $residents->where('status', 'active')->count(),
            'owners' => $residents->where('ownership_type', 'owner')->count(),
            'tenants' => $residents->where('ownership_type', 'tenant')->count(),
        ];

        return view('admin.reports.residents', compact('residents', 'stats'));
    }

    public function visitors(Request $request)
    {
        $query = Visitor::with(['resident.user']);

        if ($request->status) $query->where('status', $request->status);
        if ($request->from) $query->whereDate('created_at', '>=', $request->from);
        if ($request->to) $query->whereDate('created_at', '<=', $request->to);

        $visitors = $query->latest()->get();

        $stats = [
            'total' => $visitors->count(),
            'approved' => $visitors->where('status', 'approved')->count(),
            'denied' => $visitors->where('status', 'denied')->count(),
            'checked_in' => $visitors->where('status', 'checked_in')->count(),
        ];

        // Daily visitor trend
        $dailyTrend = Visitor::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(30))
        ->groupBy('date')
        ->orderBy('date')
        ->get();

        return view('admin.reports.visitors', compact('visitors', 'stats', 'dailyTrend'));
    }

    public function complaints(Request $request)
    {
        $query = Complaint::with(['resident.user', 'category']);

        if ($request->status) $query->where('status', $request->status);
        if ($request->priority) $query->where('priority', $request->priority);
        if ($request->from) $query->whereDate('created_at', '>=', $request->from);
        if ($request->to) $query->whereDate('created_at', '<=', $request->to);

        $complaints = $query->latest()->get();

        $byCategory = Complaint::select('category_id', DB::raw('COUNT(*) as count'))
            ->with('category')
            ->groupBy('category_id')
            ->get();

        $stats = [
            'total' => $complaints->count(),
            'pending' => $complaints->where('status', 'pending')->count(),
            'resolved' => $complaints->where('status', 'resolved')->count(),
            'avg_resolution' => Complaint::whereNotNull('resolved_at')
                ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, created_at, resolved_at)) as avg_hours')
                ->value('avg_hours'),
        ];

        return view('admin.reports.complaints', compact('complaints', 'stats', 'byCategory'));
    }

    public function maintenance(Request $request)
    {
        $query = MaintenanceRequest::with(['resident.user', 'house', 'assignedStaff']);

        if ($request->status) $query->where('status', $request->status);
        if ($request->category) $query->where('category', $request->category);
        if ($request->from) $query->whereDate('created_at', '>=', $request->from);
        if ($request->to) $query->whereDate('created_at', '<=', $request->to);

        $requests = $query->latest()->get();

        $stats = [
            'total' => $requests->count(),
            'completed' => $requests->where('status', 'completed')->count(),
            'pending' => $requests->where('status', 'pending')->count(),
            'total_cost' => $requests->whereNotNull('cost')->sum('cost'),
        ];

        return view('admin.reports.maintenance', compact('requests', 'stats'));
    }
<<<<<<< HEAD

    public function vehicles(Request $request)
    {
        $query = \App\Models\Vehicle::with(['house', 'resident.user']);

        if ($request->status) $query->where('status', $request->status);
        if ($request->type) $query->where('vehicle_type', $request->type);

        $vehicles = $query->get();

        $stats = [
            'total' => $vehicles->count(),
            'active' => $vehicles->where('status', 'active')->count(),
            'cars' => $vehicles->where('vehicle_type', 'car')->count(),
            'bikes' => $vehicles->where('vehicle_type', 'bike')->count(),
        ];

        return view('admin.reports.vehicles', compact('vehicles', 'stats'));
    }
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
