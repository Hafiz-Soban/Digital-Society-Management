<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $resident = auth()->user()->resident;
        $query    = $resident->visitors();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('visitor_name', 'like', '%' . $request->search . '%')
                  ->orWhere('visitor_phone', 'like', '%' . $request->search . '%')
                  ->orWhere('purpose', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $visitors = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total'      => $resident->visitors()->count(),
            'pending'    => $resident->visitors()->where('status', 'pending')->count(),
            'approved'   => $resident->visitors()->where('status', 'approved')->count(),
            'checked_in' => $resident->visitors()->where('status', 'checked_in')->count(),
        ];

        return view('resident.visitors.index', compact('visitors', 'stats'));
    }

    public function create()
    {
        return view('resident.visitors.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'visitor_name'    => 'required|string|max:255',
            'visitor_phone'   => 'nullable|string|max:20',
            'visitor_cnic'    => 'nullable|string|max:20',
            'vehicle_number'  => 'nullable|string|max:20',
            'purpose'         => 'required|string|max:255',
            'expected_arrival'=> 'nullable|date|after:now',
            'notes'           => 'nullable|string|max:500',
        ]);

        $resident = auth()->user()->resident;

        Visitor::create([
            'resident_id'      => $resident->id,
            'visitor_name'     => $request->visitor_name,
            'visitor_phone'    => $request->visitor_phone,
            'visitor_cnic'     => $request->visitor_cnic,
            'vehicle_number'   => $request->vehicle_number,
            'purpose'          => $request->purpose,
            'expected_arrival' => $request->expected_arrival,
            'notes'            => $request->notes,
            'status'           => 'approved', // resident-created = auto approved
        ]);

        return redirect()->route('resident.visitors.index')
            ->with('success', 'Visitor request created successfully. Security has been notified.');
    }

    public function show(Visitor $visitor)
    {
        $this->authorizeVisitor($visitor);
        $visitor->load(['approvedBy', 'securityLogs.loggedBy']);
        return view('resident.visitors.show', compact('visitor'));
    }

    public function printPass(Visitor $visitor)
    {
        $this->authorizeVisitor($visitor);
        $visitor->load(['resident.user', 'resident.house']);
        return view('resident.visitors.print', compact('visitor'));
    }

    public function edit(Visitor $visitor)
    {
        $this->authorizeVisitor($visitor);

        if (!in_array($visitor->status, ['pending', 'approved'])) {
            return back()->with('error', 'This visitor request cannot be edited.');
        }

        return view('resident.visitors.edit', compact('visitor'));
    }

    public function update(Request $request, Visitor $visitor)
    {
        $this->authorizeVisitor($visitor);

        if (!in_array($visitor->status, ['pending', 'approved'])) {
            return back()->with('error', 'This visitor request cannot be edited.');
        }

        $request->validate([
            'visitor_name'     => 'required|string|max:255',
            'visitor_phone'    => 'nullable|string|max:20',
            'visitor_cnic'     => 'nullable|string|max:20',
            'vehicle_number'   => 'nullable|string|max:20',
            'purpose'          => 'required|string|max:255',
            'expected_arrival' => 'nullable|date',
            'notes'            => 'nullable|string|max:500',
        ]);

        $visitor->update($request->only([
            'visitor_name', 'visitor_phone', 'visitor_cnic',
            'vehicle_number', 'purpose', 'expected_arrival', 'notes',
        ]));

        return redirect()->route('resident.visitors.show', $visitor)
            ->with('success', 'Visitor request updated successfully.');
    }

    public function cancel(Visitor $visitor)
    {
        $this->authorizeVisitor($visitor);

        if (!in_array($visitor->status, ['pending', 'approved'])) {
            return back()->with('error', 'This visitor request cannot be cancelled.');
        }

        $visitor->update(['status' => 'denied']);

        return redirect()->route('resident.visitors.index')
            ->with('success', 'Visitor request cancelled.');
    }

    private function authorizeVisitor(Visitor $visitor): void
    {
        if ($visitor->resident_id !== auth()->user()->resident?->id) {
            abort(403, 'Unauthorized access.');
        }
    }
}
