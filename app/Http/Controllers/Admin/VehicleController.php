<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\House;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $query = Vehicle::with(['house', 'resident.user']);

        if ($request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('vehicle_number', 'like', "%{$search}%")
                  ->orWhere('sticker_number', 'like', "%{$search}%")
                  ->orWhereHas('house', function($qh) use ($search) {
                      $qh->where('house_number', 'like', "%{$search}%");
                  })
                  ->orWhereHas('resident.user', function($qu) use ($search) {
                      $qu->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $vehicles = $query->latest()->paginate(15);
        return view('admin.vehicles.index', compact('vehicles'));
    }

    public function create()
    {
        $houses = House::where('status', 'occupied')->get();
        return view('admin.vehicles.create', compact('houses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'house_id' => 'required|exists:houses,id',
            'vehicle_number' => 'required|unique:vehicles,vehicle_number',
            'vehicle_type' => 'required|in:car,bike,suv,van,truck,other',
            'registration_number' => 'required|string',
            'sticker_number' => 'required|string|unique:vehicles,sticker_number',
            'status' => 'required|in:active,inactive',
        ]);

        $house = House::with('currentResident')->findOrFail($request->house_id);
        
        if (!$house->currentResident) {
            return back()->with('error', 'The selected house does not have an active resident.')->withInput();
        }

        Vehicle::create([
            'house_id' => $request->house_id,
            'resident_id' => $house->currentResident->id,
            'vehicle_number' => strtoupper($request->vehicle_number),
            'vehicle_type' => $request->vehicle_type,
            'registration_number' => $request->registration_number,
            'sticker_number' => $request->sticker_number,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle registered successfully.');
    }

    public function edit(Vehicle $vehicle)
    {
        $houses = House::all();
        return view('admin.vehicles.edit', compact('vehicle', 'houses'));
    }

    public function update(Request $request, Vehicle $vehicle)
    {
        $request->validate([
            'house_id' => 'required|exists:houses,id',
            'vehicle_number' => 'required|unique:vehicles,vehicle_number,' . $vehicle->id,
            'vehicle_type' => 'required|in:car,bike,suv,van,truck,other',
            'registration_number' => 'required|string',
            'sticker_number' => 'required|string|unique:vehicles,sticker_number,' . $vehicle->id,
            'status' => 'required|in:active,inactive',
        ]);

        $house = House::with('currentResident')->findOrFail($request->house_id);
        
        if (!$house->currentResident) {
            return back()->with('error', 'The selected house does not have an active resident.')->withInput();
        }

        $vehicle->update([
            'house_id' => $request->house_id,
            'resident_id' => $house->currentResident->id,
            'vehicle_number' => strtoupper($request->vehicle_number),
            'vehicle_type' => $request->vehicle_type,
            'registration_number' => $request->registration_number,
            'sticker_number' => $request->sticker_number,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle updated successfully.');
    }

    public function destroy(Vehicle $vehicle)
    {
        $vehicleId = $vehicle->id;
        $vehicleNumber = $vehicle->vehicle_number;
        $data = $vehicle->toArray();

        $vehicle->delete();

        \App\Models\ActivityLog::create([
            'model_type' => Vehicle::class,
            'model_id' => $vehicleId,
            'record_name' => $vehicleNumber,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

        return redirect()->route('admin.vehicles.index')->with('success', 'Vehicle removed successfully.');
    }

    public function getHouseOwner($houseId)
    {
        $house = House::with('currentResident.user')->find($houseId);
        if ($house && $house->currentResident) {
            return response()->json([
                'owner_name' => $house->currentResident->user->name,
                'resident_id' => $house->currentResident->id,
            ]);
        }
        return response()->json(['owner_name' => 'No active resident found'], 404);
    }
}
