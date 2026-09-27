<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Resident;
use App\Models\SecurityLog;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::with(['resident.user', 'resident.house']);

        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('visitor_name', 'like', '%' . $request->search . '%')
                  ->orWhere('visitor_phone', 'like', '%' . $request->search . '%')
                  ->orWhere('visitor_cnic', 'like', '%' . $request->search . '%')
                  ->orWhere('vehicle_number', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $visitors = $query->latest()->paginate(20)->withQueryString();

        return view('security.visitors.index', compact('visitors'));
    }

    public function show(Visitor $visitor)
    {
        $visitor->load(['resident.user', 'resident.house', 'approvedBy', 'securityLogs.loggedBy']);
        return view('security.visitors.show', compact('visitor'));
    }

    public function create()
    {
        $residents = Resident::with(['user', 'house'])->where('status', 'active')->get();
        return view('security.visitors.create', compact('residents'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'visitor_name' => 'required|string|max:255',
            'visitor_phone' => 'nullable|string|max:20',
            'visitor_cnic' => 'nullable|string|max:20',
            'vehicle_number' => 'nullable|string|max:20',
            'purpose' => 'required|string|max:255',
        ]);

        $visitor = Visitor::create([
            ...$request->all(),
            'status' => 'checked_in',
            'actual_arrival' => now(),
            'approved_by' => auth()->id(),
        ]);

        // Log the entry
        SecurityLog::create([
            'logged_by' => auth()->id(),
            'visitor_id' => $visitor->id,
            'event_type' => 'visitor_entry',
            'description' => 'Visitor ' . $visitor->visitor_name . ' checked in for ' . $visitor->purpose . '.',
            'severity' => 'info',
            'location' => 'Main Gate'
        ]);

        return redirect()->route('security.visitors.index')
            ->with('success', 'Visitor entry recorded successfully.');
    }

    public function checkOut(Visitor $visitor)
    {
        if ($visitor->status !== 'checked_in') {
            return back()->with('error', 'Visitor is not checked in.');
        }

        $visitor->update([
            'status' => 'checked_out',
            'departure_time' => now(),
        ]);

        SecurityLog::create([
            'logged_by' => auth()->id(),
            'visitor_id' => $visitor->id,
            'event_type' => 'visitor_exit',
            'description' => 'Visitor ' . $visitor->visitor_name . ' checked out.',
            'severity' => 'info',
            'location' => 'Main Gate'
        ]);

        return back()->with('success', 'Visitor checked out successfully.');
    }

    public function approve(Visitor $visitor)
    {
        if ($visitor->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be approved.');
        }

        $visitor->update([
            'status' => 'approved',
            'approved_by' => auth()->id(),
        ]);

        return back()->with('success', 'Visitor request approved successfully.');
    }

    public function deny(Visitor $visitor)
    {
        if ($visitor->status !== 'pending') {
            return back()->with('error', 'Only pending requests can be denied.');
        }

        $visitor->update([
            'status' => 'denied',
        ]);

        return back()->with('success', 'Visitor request denied.');
    }
}
