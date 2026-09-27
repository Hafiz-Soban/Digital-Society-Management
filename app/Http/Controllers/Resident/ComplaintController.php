<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    public function index(Request $request)
    {
        $resident = auth()->user()->resident;
        $query    = $resident->complaints()->with('category');

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('complaint_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $complaints = $query->latest()->paginate(10)->withQueryString();
        $categories = ComplaintCategory::where('is_active', true)->get();

        $stats = [
            'total'       => $resident->complaints()->count(),
            'pending'     => $resident->complaints()->where('status', 'pending')->count(),
            'in_progress' => $resident->complaints()->where('status', 'in_progress')->count(),
            'resolved'    => $resident->complaints()->where('status', 'resolved')->count(),
        ];

        return view('resident.complaints.index', compact('complaints', 'categories', 'stats'));
    }

    public function create()
    {
        $categories = ComplaintCategory::where('is_active', true)->get();
        return view('resident.complaints.create', compact('categories'));
    }

    public function store(Request $request)
    {
<<<<<<< HEAD
        $resident = auth()->user()->resident;

        // Restriction Logic
        $restrictionEnabled = \App\Models\Setting::get('maintenance_restriction_enabled', 'disabled');
        if ($restrictionEnabled === 'enabled' && $resident->due_amount >= 10000) {
            return back()->with('error', 'Your maintenance dues exceed PKR 10,000. Please clear your dues before creating standard complaints.');
        }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'priority'    => 'required|in:low,medium,high,urgent',
            'attachment'  => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $resident         = auth()->user()->resident;
        $complaintNumber  = 'CMP-' . str_pad(Complaint::withTrashed()->count() + 1, 4, '0', STR_PAD_LEFT);

        $attachment = null;
        if ($request->hasFile('attachment')) {
            $attachment = $request->file('attachment')->store('complaints', 'public');
        }

        $complaint = Complaint::create([
            'resident_id'      => $resident->id,
            'category_id'      => $request->category_id,
            'complaint_number' => $complaintNumber,
            'title'            => $request->title,
            'description'      => $request->description,
            'priority'         => $request->priority,
            'status'           => 'pending',
            'attachment'       => $attachment,
        ]);

        // Log the activity
        \App\Models\ComplaintLog::create([
            'complaint_id' => $complaint->id,
            'user_id'      => auth()->id(),
            'status'       => 'pending',
            'comment'      => 'Complaint submitted by resident.',
        ]);

        return redirect()->route('resident.complaints.index')
            ->with('success', 'Complaint submitted successfully. We will review it shortly.');
    }

    public function show(Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);
        $complaint->load(['category', 'assignedTo']);
        return view('resident.complaints.show', compact('complaint'));
    }

    public function edit(Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);

        if (!in_array($complaint->status, ['pending'])) {
            return back()->with('error', 'Only pending complaints can be edited.');
        }

        $categories = ComplaintCategory::where('is_active', true)->get();
        return view('resident.complaints.edit', compact('complaint', 'categories'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);

        if (!in_array($complaint->status, ['pending'])) {
            return back()->with('error', 'Only pending complaints can be edited.');
        }

        $request->validate([
            'category_id' => 'required|exists:complaint_categories,id',
            'title'       => 'required|string|max:255',
            'description' => 'required|string|min:20',
            'priority'    => 'required|in:low,medium,high,urgent',
            'attachment'  => 'nullable|file|max:5120|mimes:jpg,jpeg,png,pdf,doc,docx',
        ]);

        $attachment = $complaint->attachment;
        if ($request->hasFile('attachment')) {
            if ($attachment) Storage::disk('public')->delete($attachment);
            $attachment = $request->file('attachment')->store('complaints', 'public');
        }

        $complaint->update([
            'category_id' => $request->category_id,
            'title'       => $request->title,
            'description' => $request->description,
            'priority'    => $request->priority,
            'attachment'  => $attachment,
        ]);

        return redirect()->route('resident.complaints.show', $complaint)
            ->with('success', 'Complaint updated successfully.');
    }

    public function destroy(Complaint $complaint)
    {
        $this->authorizeComplaint($complaint);

        if ($complaint->status !== 'pending') {
            return back()->with('error', 'Only pending complaints can be deleted.');
        }

        if ($complaint->attachment) {
            Storage::disk('public')->delete($complaint->attachment);
        }

        $complaint->delete();

        return redirect()->route('resident.complaints.index')
            ->with('success', 'Complaint deleted successfully.');
    }

    private function authorizeComplaint(Complaint $complaint): void
    {
        if ($complaint->resident_id !== auth()->user()->resident?->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
