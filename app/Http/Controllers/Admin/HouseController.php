<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\House;
use App\Models\Resident;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    public function index(Request $request)
    {
        $query = House::with('currentResident.user');

        if ($request->search) {
            $query->where('house_number', 'like', '%' . $request->search . '%')
                  ->orWhere('block', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->is_rented) {
            $query->where('is_rented', $request->is_rented);
        }

        $houses = $query->orderBy('house_number')->paginate(15)->withQueryString();

        $stats = [
            'total' => House::count(),
            'occupied' => House::where('status', 'occupied')->count(),
            'vacant' => House::where('status', 'vacant')->count(),
            'maintenance' => House::where('status', 'under_maintenance')->count(),
        ];

        return view('admin.houses.index', compact('houses', 'stats'));
    }

    public function create()
    {
        return view('admin.houses.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'house_number' => 'required|string|unique:houses,house_number',
            'block' => 'nullable|string|max:10',
            'floor' => 'required|in:Ground Floor,First Floor,Second Floor',
            'bedrooms' => 'required|integer|min:1',
            'area_sqft' => 'nullable|numeric|min:0',
<<<<<<< HEAD
=======
            'monthly_maintenance' => 'required|numeric|min:0',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'description' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'owner_cnic' => 'required|string|max:20',
            'owner_phone' => 'required|string|max:20',
            'is_rented' => 'required|in:yes,no',
            'tenant_name' => 'required_if:is_rented,yes|nullable|string|max:255',
            'tenant_father_name' => 'required_if:is_rented,yes|nullable|string|max:255',
            'tenant_cnic' => 'required_if:is_rented,yes|nullable|string|max:20',
            'tenant_contact' => 'required_if:is_rented,yes|nullable|string|max:20',
            'rent_agreement_status' => 'required_if:is_rented,yes|nullable|in:issued,not_issued',
            'rent_agreement_picture' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('rent_agreement_picture')) {
            $data['rent_agreement_path'] = $request->file('rent_agreement_picture')->store('rent_agreements', 'public');
        }

        House::create($data);

        return redirect()->route('admin.houses.index')
            ->with('success', 'House added successfully.');
    }

    public function show(House $house)
    {
<<<<<<< HEAD
        $house->load(['residents.user', 'maintenanceRequests' => fn($q) => $q->latest()->take(5), 'vehicles']);
        $maintenanceRequests = $house->maintenanceRequests()->latest()->paginate(5);
        return view('admin.houses.show', compact('house', 'maintenanceRequests'));
=======
        $house->load(['residents.user', 'maintenanceRequests' => fn($q) => $q->latest()->take(5)]);
        return view('admin.houses.show', compact('house'));
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function edit(House $house)
    {
        return view('admin.houses.edit', compact('house'));
    }

    public function update(Request $request, House $house)
    {
        $request->validate([
            'house_number' => 'required|string|unique:houses,house_number,' . $house->id,
            'block' => 'nullable|string|max:10',
            'floor' => 'required|in:Ground Floor,First Floor,Second Floor',
            'bedrooms' => 'required|integer|min:1',
            'area_sqft' => 'nullable|numeric|min:0',
<<<<<<< HEAD
=======
            'monthly_maintenance' => 'required|numeric|min:0',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'status' => 'required|in:occupied,vacant,under_maintenance',
            'description' => 'nullable|string',
            'owner_name' => 'required|string|max:255',
            'owner_cnic' => 'required|string|max:20',
            'owner_phone' => 'required|string|max:20',
            'is_rented' => 'required|in:yes,no',
            'tenant_name' => 'required_if:is_rented,yes|nullable|string|max:255',
            'tenant_father_name' => 'required_if:is_rented,yes|nullable|string|max:255',
            'tenant_cnic' => 'required_if:is_rented,yes|nullable|string|max:20',
            'tenant_contact' => 'required_if:is_rented,yes|nullable|string|max:20',
            'rent_agreement_status' => 'required_if:is_rented,yes|nullable|in:issued,not_issued',
            'rent_agreement_picture' => 'nullable|file|mimes:jpg,png,jpeg,pdf|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('rent_agreement_picture')) {
            $data['rent_agreement_path'] = $request->file('rent_agreement_picture')->store('rent_agreements', 'public');
        }

        $house->update($data);

        return redirect()->route('admin.houses.index')
            ->with('success', 'House updated successfully.');
    }

    public function destroy(House $house)
    {
        if ($house->status === 'occupied') {
            return back()->with('error', 'Cannot delete an occupied house. Please move out the resident first.');
        }

<<<<<<< HEAD
        $houseId = $house->id;
        $houseNumber = $house->house_number;
        $data = $house->toArray();

        $house->delete();

        \App\Models\ActivityLog::create([
            'model_type' => House::class,
            'model_id' => $houseId,
            'record_name' => $houseNumber,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

=======
        $house->delete();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return redirect()->route('admin.houses.index')
            ->with('success', 'House deleted successfully.');
    }
}
