<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffSalary;
use Illuminate\Http\Request;

class StaffSalaryController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffSalary::with('staff');

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('month')) {
            $query->where('month', $request->month);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $salaries = $query->latest()->paginate(20);
        $staffMembers = Staff::all();

        return view('admin.staff.salaries.index', compact('salaries', 'staffMembers'));
    }

    public function create()
    {
        $staffMembers = Staff::where('status', 'active')->get();
        return view('admin.staff.salaries.create', compact('staffMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'amount' => 'required|numeric|min:0',
            'month' => 'required|string',
            'payment_date' => 'nullable|date',
            'status' => 'required|in:paid,pending',
        ]);

        StaffSalary::create($validated);

        return redirect()->route('admin.staff.salaries.index')->with('success', 'Salary record created successfully.');
    }

    public function update(Request $request, StaffSalary $salary)
    {
        $validated = $request->validate([
            'payment_date' => 'nullable|date',
            'status' => 'required|in:paid,pending',
        ]);

        $salary->update($validated);

        return back()->with('success', 'Salary status updated.');
    }
}
