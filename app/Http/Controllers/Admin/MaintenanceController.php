<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use App\Models\MaintenanceStaff;
use App\Models\Notification;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $query = MaintenanceRequest::with(['resident.user', 'house', 'assignedStaff']);

        if ($request->search) {
            $query->where('request_number', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $requests = $query->latest()->paginate(15)->withQueryString();
        $staff = MaintenanceStaff::where('status', 'available')->get();

        $stats = [
            'pending' => MaintenanceRequest::where('status', 'pending')->count(),
            'in_progress' => MaintenanceRequest::where('status', 'in_progress')->count(),
            'completed' => MaintenanceRequest::where('status', 'completed')->count(),
            'total' => MaintenanceRequest::count(),
        ];

        return view('admin.maintenance.index', compact('requests', 'staff', 'stats'));
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $maintenance->load(['resident.user', 'house', 'assignedStaff']);
        $staff = MaintenanceStaff::all();
        return view('admin.maintenance.show', compact('maintenance', 'staff'));
    }

    public function assign(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'assigned_staff_id' => 'required|exists:maintenance_staff,id',
            'scheduled_date' => 'nullable|date',
        ]);

        $maintenance->update([
            'assigned_staff_id' => $request->assigned_staff_id,
            'scheduled_date' => $request->scheduled_date,
            'status' => 'assigned',
        ]);

        $staffMember = MaintenanceStaff::find($request->assigned_staff_id);
        $staffMember->update(['status' => 'busy']);

        // Log activity
        \App\Models\MaintenanceLog::create([
            'maintenance_request_id' => $maintenance->id,
            'user_id' => auth()->id(),
            'status' => 'assigned',
            'comment' => 'Request assigned to staff: ' . $staffMember->name . '.',
        ]);

        Notification::create([
            'user_id' => $maintenance->resident->user_id,
            'title' => 'Maintenance Request Assigned',
            'message' => 'Your maintenance request #' . $maintenance->request_number . ' has been assigned.',
            'type' => 'info',
            'icon' => 'bi-tools',
            'link' => route('resident.maintenance.show', $maintenance),
            'notifiable_type' => MaintenanceRequest::class,
            'notifiable_id' => $maintenance->id,
        ]);

        return back()->with('success', 'Maintenance request assigned successfully.');
    }

    public function updateStatus(Request $request, MaintenanceRequest $maintenance)
    {
        $request->validate([
            'status' => 'required|in:pending,assigned,in_progress,completed,cancelled',
            'completion_notes' => 'nullable|string',
            'cost' => 'nullable|numeric|min:0',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'completed') {
            $data['completed_at'] = now();
            $data['completion_notes'] = $request->completion_notes;
            $data['cost'] = $request->cost;

            if ($maintenance->assignedStaff) {
                $maintenance->assignedStaff->update(['status' => 'available']);
            }
        }

        $maintenance->update($data);

        // Log activity
        \App\Models\MaintenanceLog::create([
            'maintenance_request_id' => $maintenance->id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'comment' => $request->completion_notes ?? 'Status updated to ' . ucfirst($request->status) . '.',
        ]);

        Notification::create([
            'user_id' => $maintenance->resident->user_id,
            'title' => 'Maintenance Status Updated',
            'message' => 'Your maintenance request #' . $maintenance->request_number . ' is now: ' . ucfirst($request->status),
            'type' => $request->status === 'completed' ? 'success' : 'info',
            'icon' => 'bi-tools',
            'link' => route('resident.maintenance.show', $maintenance),
            'notifiable_type' => MaintenanceRequest::class,
            'notifiable_id' => $maintenance->id,
        ]);

        return back()->with('success', 'Status updated successfully.');
    }

    // Maintenance Staff Management
    public function staffIndex()
    {
        $staff = MaintenanceStaff::with('maintenanceRequests')->paginate(15);
        return view('admin.maintenance.staff', compact('staff'));
    }

    public function staffStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:100',
        ]);

        MaintenanceStaff::create($request->all());
        return back()->with('success', 'Staff member added successfully.');
    }

    public function staffUpdate(Request $request, MaintenanceStaff $staff)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'specialization' => 'required|string|max:100',
            'status' => 'required|in:available,busy,off_duty',
        ]);

        $staff->update($request->all());
        return back()->with('success', 'Staff member updated successfully.');
    }

    public function staffDestroy(MaintenanceStaff $staff)
    {
<<<<<<< HEAD
        $staffId = $staff->id;
        $staffName = $staff->name;
        $data = $staff->toArray();

        $staff->delete();

        \App\Models\ActivityLog::create([
            'model_type' => MaintenanceStaff::class,
            'model_id' => $staffId,
            'record_name' => $staffName,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

=======
        $staff->delete();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return back()->with('success', 'Staff member removed.');
    }
}
