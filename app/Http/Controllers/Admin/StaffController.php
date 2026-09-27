<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Staff;
<<<<<<< HEAD
use App\Models\Resident;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = Staff::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('employee_id', 'like', "%{$search}%")
                    ->orWhere('phone_number', 'like', "%{$search}%")
                    ->orWhere('designation', 'like', "%{$search}%");
            });
        }

        if ($request->filled('designation')) {
            $query->where('designation', 'like', "%{$request->designation}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $staffMembers = $query->latest()->paginate(10);

=======
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staffMembers = Staff::latest()->paginate(10);
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return view('admin.staff.index', compact('staffMembers'));
    }

    public function create()
    {
<<<<<<< HEAD
        // Auto-generate Employee ID
        $lastStaff = Staff::withTrashed()->latest('id')->first();
        $nextId = $lastStaff ? $lastStaff->id + 1 : 1;
        $employeeId = 'EMP-' . str_pad($nextId, 4, '0', STR_PAD_LEFT);

        return view('admin.staff.create', compact('employeeId'));
=======
        return view('admin.staff.create');
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'full_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'cnic' => 'required|string|max:20|unique:staff,cnic',
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'employee_id' => 'required|string|unique:staff,employee_id',
            'designation' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'shift_timing' => 'required|string',
            'status' => 'required|in:active,inactive',
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'emergency_relation' => 'required|string|max:100',
        ]);

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('staff_photos', 'public');
            $validated['photo_path'] = $path;
        }

        DB::transaction(function () use ($validated) {
            $staff = Staff::create($validated);

            if (stripos($staff->designation, 'Supervisor') !== false && $staff->status === 'active') {
                $this->updateResidentEmergencyContacts($staff);
            }
        });
=======
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email',
            'phone' => 'required|string|max:20',
            'designation' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        Staff::create($validated);
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

        return redirect()->route('admin.staff.index')->with('success', 'Staff member added successfully.');
    }

<<<<<<< HEAD
    public function show(Staff $staff)
    {
        $staff->load(['attendance' => function ($q) {
            $q->latest()->limit(10);
        }, 'salaries' => function ($q) {
            $q->latest()->limit(10);
        }, 'advances' => function ($q) {
            $q->latest()->limit(10);
        }]);

        return view('admin.staff.show', compact('staff'));
    }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    public function edit(Staff $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(Request $request, Staff $staff)
    {
        $validated = $request->validate([
<<<<<<< HEAD
            'full_name' => 'required|string|max:255',
            'father_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'required|string|max:20',
            'alternate_phone' => 'nullable|string|max:20',
            'cnic' => 'required|string|max:20|unique:staff,cnic,' . $staff->id,
            'dob' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'address' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'designation' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'salary' => 'required|numeric|min:0',
            'shift_timing' => 'required|string',
            'status' => 'required|in:active,inactive',
            'emergency_name' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:20',
            'emergency_relation' => 'required|string|max:100',
        ]);

        if ($request->hasFile('photo')) {
            if ($staff->photo_path) {
                Storage::disk('public')->delete($staff->photo_path);
            }
            $path = $request->file('photo')->store('staff_photos', 'public');
            $validated['photo_path'] = $path;
        }

        DB::transaction(function () use ($staff, $validated) {
            $oldDesignation = $staff->designation;
            $staff->update($validated);

            if (stripos($staff->designation, 'Supervisor') !== false && ($oldDesignation !== $staff->designation || $staff->wasChanged('phone_number') || $staff->wasChanged('full_name'))) {
                $this->updateResidentEmergencyContacts($staff);
            }
        });
=======
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:staff,email,' . $staff->id,
            'phone' => 'required|string|max:20',
            'designation' => 'required|string|max:255',
            'salary' => 'required|numeric|min:0',
            'joining_date' => 'required|date',
            'address' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $staff->update($validated);
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

        return redirect()->route('admin.staff.index')->with('success', 'Staff member updated successfully.');
    }

    public function destroy(Staff $staff)
    {
<<<<<<< HEAD
        $recordName = $staff->full_name;
        $staffId = $staff->id;
        $data = $staff->toArray();

        $staff->delete();

        ActivityLog::create([
            'model_type' => Staff::class,
            'model_id' => $staffId,
            'record_name' => $recordName,
            'action' => 'deleted',
            'user_id' => Auth::id(),
            'data' => $data
        ]);

        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }

    private function updateResidentEmergencyContacts(Staff $supervisor)
    {
        Resident::query()->update([
            'emergency_contact_name' => $supervisor->full_name,
            'emergency_contact_phone' => $supervisor->phone_number,
            'emergency_contact_relation' => 'Society Supervisor'
        ]);
    }

    public function dashboard()
    {
        $stats = [
            'total_staff' => Staff::count(),
            'active_staff' => Staff::where('status', 'active')->count(),
            'supervisors' => Staff::where('designation', 'like', '%Supervisor%')->count(),
            'security_guards' => Staff::where('designation', 'like', '%Guard%')->count(),
            'monthly_salary_expense' => Staff::where('status', 'active')->sum('salary'),
            'total_advances' => \App\Models\StaffAdvance::sum('amount'),
        ];

        return view('admin.staff.dashboard', compact('stats'));
    }
=======
        $staff->delete();
        return redirect()->route('admin.staff.index')->with('success', 'Staff member deleted successfully.');
    }
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
