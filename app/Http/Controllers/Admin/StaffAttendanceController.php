<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Illuminate\Http\Request;

class StaffAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $query = StaffAttendance::with('staff');

        if ($request->filled('date')) {
            $query->whereDate('date', $request->date);
        } else {
            $query->whereDate('date', now()->toDateString());
        }

        if ($request->filled('staff_id')) {
            $query->where('staff_id', $request->staff_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $attendance = $query->latest()->paginate(20);
        $staffMembers = Staff::where('status', 'active')->get();

        return view('admin.staff.attendance.index', compact('attendance', 'staffMembers'));
    }

    public function create()
    {
        $staffMembers = Staff::where('status', 'active')->get();
        return view('admin.staff.attendance.create', compact('staffMembers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'staff_id' => 'required|exists:staff,id',
            'date' => 'required|date',
            'check_in' => 'nullable|date_format:H:i',
            'check_out' => 'nullable|date_format:H:i',
            'status' => 'required|in:present,absent,leave',
        ]);

        StaffAttendance::updateOrCreate(
            ['staff_id' => $validated['staff_id'], 'date' => $validated['date']],
            $validated
        );

        return redirect()->route('admin.staff.attendance.index')->with('success', 'Attendance recorded successfully.');
    }
}
