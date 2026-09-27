<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\DomesticStaff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DomesticStaffController extends Controller
{
    private const STAFF_TYPES = [
        'maid' => 'Maid',
        'driver' => 'Driver',
        'cook' => 'Cook',
        'electrician' => 'Electrician',
        'gardener' => 'Gardener',
        'plumber' => 'Plumber',
        'security_guard' => 'Security Guard',
        'other' => 'Other',
    ];

    public function index(Request $request)
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $query = DomesticStaff::query()->where('resident_id', $resident->id);

        if ($search = $request->string('search')->trim()->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('cnic', 'like', "%{$search}%");
            });
        }

        if ($type = $request->string('staff_type')->trim()->toString()) {
            $query->where('staff_type', $type);
        }

        if ($status = $request->string('status')->trim()->toString()) {
            $query->where('status', $status);
        }

        $staff = $query->latest()->paginate(10)->withQueryString();

        $stats = [
            'total' => DomesticStaff::where('resident_id', $resident->id)->count(),
            'active' => DomesticStaff::where('resident_id', $resident->id)->where('status', 'active')->count(),
            'inactive' => DomesticStaff::where('resident_id', $resident->id)->where('status', 'inactive')->count(),
        ];

        return view('resident.domestic-staff.index', [
            'staff' => $staff,
            'stats' => $stats,
            'staffTypes' => self::STAFF_TYPES,
        ]);
    }

    public function create()
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        return view('resident.domestic-staff.create', [
            'staffTypes' => self::STAFF_TYPES,
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cnic' => 'nullable|string|max:25',
            'mobile' => 'nullable|string|max:25',
            'staff_type' => 'required|in:' . implode(',', array_keys(self::STAFF_TYPES)),
            'joining_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $photoPath = null;
        if ($request->hasFile('profile_photo')) {
            $photoPath = $request->file('profile_photo')->store('domestic_staff', 'public');
        }

        $staff = DomesticStaff::create([
            'resident_id' => $resident->id,
            ...collect($validated)->except('profile_photo')->all(),
            'profile_photo_path' => $photoPath,
            'qr_token' => (string) Str::uuid(),
        ]);

        return redirect()->route('resident.domestic-staff.show', $staff->id)
            ->with('success', 'Staff member added successfully.');
    }

    public function show(int $staff)
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $staffMember = DomesticStaff::where('resident_id', $resident->id)->findOrFail($staff);

        $attendances = $staffMember->attendances()->paginate(10);

        return view('resident.domestic-staff.show', [
            'staffMember' => $staffMember,
            'attendances' => $attendances,
            'staffTypes' => self::STAFF_TYPES,
        ]);
    }

    public function edit(int $staff)
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $staffMember = DomesticStaff::where('resident_id', $resident->id)->findOrFail($staff);

        return view('resident.domestic-staff.edit', [
            'staffMember' => $staffMember,
            'staffTypes' => self::STAFF_TYPES,
        ]);
    }

    public function update(Request $request, int $staff)
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $staffMember = DomesticStaff::where('resident_id', $resident->id)->findOrFail($staff);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'cnic' => 'nullable|string|max:25',
            'mobile' => 'nullable|string|max:25',
            'staff_type' => 'required|in:' . implode(',', array_keys(self::STAFF_TYPES)),
            'joining_date' => 'nullable|date',
            'status' => 'required|in:active,inactive',
            'address' => 'nullable|string',
            'emergency_contact' => 'nullable|string|max:100',
            'profile_photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('profile_photo')) {
            if ($staffMember->profile_photo_path) {
                Storage::disk('public')->delete($staffMember->profile_photo_path);
            }

            $staffMember->profile_photo_path = $request->file('profile_photo')->store('domestic_staff', 'public');
        }

        $staffMember->fill(collect($validated)->except('profile_photo')->all());
        $staffMember->save();

        return redirect()->route('resident.domestic-staff.show', $staffMember->id)
            ->with('success', 'Staff member updated successfully.');
    }

    public function destroy(int $staff)
    {
        $user = auth()->user();
        $resident = $user->resident;

        if (!$resident) {
            return view('resident.no-profile');
        }

        $staffMember = DomesticStaff::where('resident_id', $resident->id)->findOrFail($staff);

        if ($staffMember->profile_photo_path) {
            Storage::disk('public')->delete($staffMember->profile_photo_path);
        }

        $staffMember->delete();

        return redirect()->route('resident.domestic-staff.index')
            ->with('success', 'Staff member deleted successfully.');
    }
}

