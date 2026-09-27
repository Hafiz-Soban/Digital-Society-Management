<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffAdvance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StaffAdvanceController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffAdvance::with(['staff', 'approver']);

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('staff', function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%");
            });
        }

        $advances = $query->latest()->paginate(20);
        $staffMembers = Staff::all();

        return view('admin.staff.advances.index', compact('advances', 'staffMembers'));
    }

    public function create()
    {
        $staffMembers = Staff::where('status', 'active')->get();
        return view('admin.staff.advances.create', compact('staffMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'amount' => 'required|numeric|min:0',
            'advance_date' => 'required|date',
            'reason' => 'required|string|max:255',
            'notes' => 'nullable|string',
        ]);

        $validated['approved_by'] = Auth::id();

        StaffAdvance::create($validated);

        return redirect()->route('admin.staff.advances.index')->with('success', 'Advance salary recorded successfully.');
    }
}
