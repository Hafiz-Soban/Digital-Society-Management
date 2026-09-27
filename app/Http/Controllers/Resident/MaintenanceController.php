<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\MaintenanceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaintenanceController extends Controller
{
    public function index(Request $request)
    {
        $resident = auth()->user()->resident;
        $query    = $resident->maintenanceRequests()->with(['house', 'assignedStaff']);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('request_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category) {
            $query->where('category', $request->category);
        }

        $requests = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total'       => $resident->maintenanceRequests()->count(),
            'pending'     => $resident->maintenanceRequests()->where('status', 'pending')->count(),
            'in_progress' => $resident->maintenanceRequests()->where('status', 'in_progress')->count(),
            'completed'   => $resident->maintenanceRequests()->where('status', 'completed')->count(),
        ];

        return view('resident.maintenance.index', compact('requests', 'stats'));
    }

    public function create()
    {
        $resident = auth()->user()->resident;

        if (!$resident?->house_id) {
            return redirect()->route('resident.dashboard')
                ->with('error', 'You must be assigned to a house to submit a maintenance request.');
        }

        return view('resident.maintenance.create', compact('resident'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'category'    => 'required|in:plumbing,electrical,carpentry,painting,cleaning,other',
            'priority'    => 'required|in:low,medium,high,urgent',
            'attachment'  => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $resident = auth()->user()->resident;

        if (!$resident->house_id) {
            return back()->with('error', 'You must be assigned to a house to submit a maintenance request.');
        }

        $requestNumber = 'MNT-' . str_pad(MaintenanceRequest::withTrashed()->count() + 1, 4, '0', STR_PAD_LEFT);

        $attachment = null;
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->store('maintenance', 'public');
        }

        $maintenance = MaintenanceRequest::create([
            'resident_id'    => $resident->id,
            'house_id'       => $resident->house_id,
            'request_number' => $requestNumber,
            'title'          => $request->title,
            'description'    => $request->description,
            'category'       => $request->category,
            'priority'       => $request->priority,
            'status'         => 'pending',
            'attachment'     => $attachment,
        ]);

        // Log activity
        \App\Models\MaintenanceLog::create([
            'maintenance_request_id' => $maintenance->id,
            'user_id' => auth()->id(),
            'status' => 'pending',
            'comment' => 'Maintenance request submitted by resident.',
        ]);

        return redirect()->route('resident.maintenance.index')
            ->with('success', 'Maintenance request submitted successfully.');
    }

    public function show(MaintenanceRequest $maintenance)
    {
        $this->authorizeMaintenance($maintenance);
        $maintenance->load(['house', 'assignedStaff']);
        return view('resident.maintenance.show', compact('maintenance'));
    }

    public function edit(MaintenanceRequest $maintenance)
    {
        $this->authorizeMaintenance($maintenance);

        if (!in_array($maintenance->status, ['pending'])) {
            return back()->with('error', 'Only pending requests can be edited.');
        }

        return view('resident.maintenance.edit', compact('maintenance'));
    }

    public function update(Request $request, MaintenanceRequest $maintenance)
    {
        $this->authorizeMaintenance($maintenance);

        if (!in_array($maintenance->status, ['pending'])) {
            return back()->with('error', 'Only pending requests can be edited.');
        }

        $request->validate([
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'category'    => 'required|in:plumbing,electrical,carpentry,painting,cleaning,other',
            'priority'    => 'required|in:low,medium,high,urgent',
            'attachment'  => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf',
        ]);

        $attachment = $maintenance->attachment;
        if ($request->hasFile('attachment')) {
            if ($attachment) Storage::disk('public')->delete($attachment);
            $attachment = $request->file('attachment')->store('maintenance', 'public');
        }

        $maintenance->update([
            'title'       => $request->title,
            'description' => $request->description,
            'category'    => $request->category,
            'priority'    => $request->priority,
            'attachment'  => $attachment,
        ]);

        return redirect()->route('resident.maintenance.show', $maintenance)
            ->with('success', 'Maintenance request updated successfully.');
    }

    public function cancel(MaintenanceRequest $maintenance)
    {
        $this->authorizeMaintenance($maintenance);

        if (!in_array($maintenance->status, ['pending'])) {
            return back()->with('error', 'Only pending requests can be cancelled.');
        }

        $maintenance->update(['status' => 'cancelled']);

        return redirect()->route('resident.maintenance.index')
            ->with('success', 'Maintenance request cancelled.');
    }

    private function authorizeMaintenance(MaintenanceRequest $maintenance): void
    {
        if ($maintenance->resident_id !== auth()->user()->resident?->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
