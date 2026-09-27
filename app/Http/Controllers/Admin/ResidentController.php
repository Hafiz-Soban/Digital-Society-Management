<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\User;
use App\Models\House;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class ResidentController extends Controller
{
    public function index(Request $request)
    {
        $query = Resident::with(['user', 'house']);

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%');
            })->orWhere('resident_id', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->house_id) {
            $query->where('house_id', $request->house_id);
        }

        $residents = $query->latest()->paginate(15)->withQueryString();
        $houses = House::where('status', 'vacant')->orWhereHas('currentResident')->get();

        return view('admin.residents.index', compact('residents', 'houses'));
    }

    public function create()
    {
        $houses = House::where('status', 'vacant')->get();
        return view('admin.residents.create', compact('houses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'house_id' => 'nullable|exists:houses,id',
            'cnic' => 'nullable|string|unique:residents,cnic',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'ownership_type' => 'required|in:owner,tenant',
            'move_in_date' => 'nullable|date',
            'family_members' => 'required|integer|min:1',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($request) {
            $residentRole = Role::where('name', 'resident')->first();

            // Auto-generate email and password for residents since they are no longer asked
            $email = strtolower(str_replace(' ', '.', $request->name)) . '.' . rand(100, 999) . '@society.com';
            $password = Hash::make('resident123'); // Default password

            $user = User::create([
                'role_id' => $residentRole->id,
                'name' => $request->name,
                'email' => $email,
                'phone' => $request->phone,
                'password' => $password,
                'status' => 'active',
            ]);

            $residentId = 'RES-' . str_pad(Resident::withTrashed()->count() + 1, 3, '0', STR_PAD_LEFT);

            Resident::create([
                'user_id' => $user->id,
                'house_id' => $request->house_id,
                'resident_id' => $residentId,
                'cnic' => $request->cnic,
                'date_of_birth' => $request->date_of_birth,
                'gender' => $request->gender,
                'ownership_type' => $request->ownership_type,
                'move_in_date' => $request->move_in_date,
                'family_members' => $request->family_members,
                'emergency_contact_name' => $request->emergency_contact_name,
                'emergency_contact_phone' => $request->emergency_contact_phone,
                'emergency_contact_relation' => $request->emergency_contact_relation,
                'status' => 'active',
            ]);

            // Update house status
            if ($request->house_id) {
                House::find($request->house_id)->update(['status' => 'occupied']);
            }
        });

        return redirect()->route('admin.residents.index')
            ->with('success', 'Resident added successfully.');
    }

    public function show(Resident $resident)
    {
        $resident->load(['user', 'house', 'visitors' => fn($q) => $q->latest()->take(5),
            'complaints' => fn($q) => $q->latest()->take(5),
            'maintenanceRequests' => fn($q) => $q->latest()->take(5),
            'trustScore']);
        return view('admin.residents.show', compact('resident'));
    }

    public function edit(Resident $resident)
    {
        $resident->load('user');
        $houses = House::whereIn('status', ['vacant', 'occupied'])->get();
        return view('admin.residents.edit', compact('resident', 'houses'));
    }

    public function update(Request $request, Resident $resident)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'house_id' => 'nullable|exists:houses,id',
            'cnic' => 'nullable|string|unique:residents,cnic,' . $resident->id,
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'ownership_type' => 'required|in:owner,tenant',
            'move_in_date' => 'nullable|date',
            'family_members' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive,moved_out',
        ]);

        DB::transaction(function () use ($request, $resident) {
            $resident->user->update([
                'name' => $request->name,
                'phone' => $request->phone,
            ]);

            // Handle house change
            if ($resident->house_id && $resident->house_id != $request->house_id) {
                House::find($resident->house_id)->update(['status' => 'vacant']);
            }
            if ($request->house_id && $request->house_id != $resident->house_id) {
                House::find($request->house_id)->update(['status' => 'occupied']);
            }

            $resident->update($request->only([
                'house_id', 'cnic', 'date_of_birth', 'gender', 'ownership_type',
                'move_in_date', 'move_out_date', 'family_members', 'status',
                'emergency_contact_name', 'emergency_contact_phone', 'emergency_contact_relation',
                'notes',
            ]));
        });

        return redirect()->route('admin.residents.index')
            ->with('success', 'Resident updated successfully.');
    }

    public function destroy(Resident $resident)
    {
<<<<<<< HEAD
        $residentId = $resident->id;
        $residentName = $resident->user->name;
        $data = $resident->toArray();

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        DB::transaction(function () use ($resident) {
            if ($resident->house_id) {
                House::find($resident->house_id)->update(['status' => 'vacant']);
            }
            $resident->user->delete();
            $resident->delete();
        });

<<<<<<< HEAD
        \App\Models\ActivityLog::create([
            'model_type' => Resident::class,
            'model_id' => $residentId,
            'record_name' => $residentName,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return redirect()->route('admin.residents.index')
            ->with('success', 'Resident deleted successfully.');
    }
}
