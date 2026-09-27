<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $query = Complaint::with(['resident.user', 'category', 'assignedTo']);

        if ($request->search) {
            $query->where('complaint_number', 'like', '%' . $request->search . '%')
                  ->orWhere('title', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $complaints = $query->latest()->paginate(15)->withQueryString();
        $categories = ComplaintCategory::where('is_active', true)->get();
        $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();

        $stats = [
            'pending' => Complaint::where('status', 'pending')->count(),
            'in_progress' => Complaint::where('status', 'in_progress')->count(),
            'resolved' => Complaint::where('status', 'resolved')->count(),
            'escalated' => Complaint::where('status', 'escalated')->count(),
        ];

        return view('admin.complaints.index', compact('complaints', 'categories', 'admins', 'stats'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['resident.user', 'category', 'assignedTo']);
        $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))->get();
        return view('admin.complaints.show', compact('complaint', 'admins'));
    }

    public function assign(Request $request, Complaint $complaint)
    {
        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        $complaint->update([
            'assigned_to' => $request->assigned_to,
            'status' => 'in_progress',
        ]);

        // Log the activity
        \App\Models\ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'status' => 'in_progress',
            'comment' => 'Complaint assigned to ' . User::find($request->assigned_to)->name . '.',
        ]);

        // Notify resident
        Notification::create([
            'user_id' => $complaint->resident->user_id,
            'title' => 'Complaint Assigned',
            'message' => 'Your complaint #' . $complaint->complaint_number . ' has been assigned and is now in progress.',
            'type' => 'info',
            'icon' => 'bi-person-check',
            'link' => route('resident.complaints.show', $complaint),
            'notifiable_type' => Complaint::class,
            'notifiable_id' => $complaint->id,
        ]);

        return back()->with('success', 'Complaint assigned successfully.');
    }

    public function updateStatus(Request $request, Complaint $complaint)
    {
        $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed,escalated',
            'resolution_notes' => 'nullable|string',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'resolved') {
            $data['resolved_at'] = now();
            $data['resolution_notes'] = $request->resolution_notes;
        }

        $complaint->update($data);

        // Log the activity
        \App\Models\ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'status' => $request->status,
            'comment' => $request->resolution_notes ?? 'Status updated to ' . ucfirst($request->status) . '.',
        ]);

        // Notify resident
        Notification::create([
            'user_id' => $complaint->resident->user_id,
            'title' => 'Complaint Status Updated',
            'message' => 'Your complaint #' . $complaint->complaint_number . ' status changed to: ' . ucfirst($request->status),
            'type' => $request->status === 'resolved' ? 'success' : 'info',
            'icon' => 'bi-clipboard-check',
            'link' => route('resident.complaints.show', $complaint),
            'notifiable_type' => Complaint::class,
            'notifiable_id' => $complaint->id,
        ]);

        return back()->with('success', 'Complaint status updated successfully.');
    }

    public function destroy(Complaint $complaint)
    {
<<<<<<< HEAD
        $complaintId = $complaint->id;
        $complaintNumber = $complaint->complaint_number;
        $data = $complaint->toArray();

        $complaint->delete();

        \App\Models\ActivityLog::create([
            'model_type' => Complaint::class,
            'model_id' => $complaintId,
            'record_name' => $complaintNumber,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

=======
        $complaint->delete();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }
}
