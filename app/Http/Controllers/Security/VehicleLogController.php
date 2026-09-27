<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleLog;
use App\Models\VehicleAlert;
use App\Models\House;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VehicleLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VehicleLog::with(['vehicle', 'house', 'securityGuard']);

        if ($request->search) {
            $search = $request->search;
            $query->where('vehicle_number', 'like', "%{$search}%")
                  ->orWhere('driver_name', 'like', "%{$search}%");
        }

        $logs = $query->latest()->paginate(15);
        
        // Add a flag for editability (1 hour window for the same guard)
        $logs->getCollection()->transform(function ($log) {
            $log->is_editable = $log->security_guard_id === auth()->id() && 
                                $log->created_at->diffInMinutes(now()) <= 60;
            return $log;
        });

        return view('security.vehicle-logs.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'vehicle_number' => 'required|string',
            'house_id' => 'nullable|exists:houses,id',
            'driver_name' => 'nullable|string',
        ]);

        $vehicleNumber = strtoupper($request->vehicle_number);
        $vehicle = Vehicle::where('vehicle_number', $vehicleNumber)->first();
        
        $entryStatus = $vehicle ? 'verified' : 'unknown';
        
        $log = VehicleLog::create([
            'vehicle_id' => $vehicle?->id,
            'vehicle_number' => $vehicleNumber,
            'house_id' => $request->house_id,
            'driver_name' => $request->driver_name,
            'entry_time' => now(),
            'entry_status' => $entryStatus,
            'security_guard_id' => auth()->id(),
        ]);

        if ($entryStatus === 'unknown') {
            $this->createAlert($vehicleNumber, 'unknown_vehicle', "Unknown vehicle entry recorded at the gate.");
        }

        return redirect()->back()->with('success', 'Vehicle entry recorded successfully.');
    }

    public function edit(VehicleLog $log)
    {
        if (auth()->user()->role !== 'admin') {
            if ($log->security_guard_id !== auth()->id() || $log->created_at->diffInMinutes(now()) > 60) {
                return back()->with('error', 'You can no longer edit this record.');
            }
        }

        $houses = House::all();
        return view('security.vehicle-logs.edit', compact('log', 'houses'));
    }

    public function update(Request $request, VehicleLog $log)
    {
        // For exit time update
        if ($request->has('record_exit')) {
            $log->update(['exit_time' => now()]);
            return redirect()->back()->with('success', 'Vehicle exit recorded successfully.');
        }

        // For actual record editing
        if (auth()->user()->role !== 'admin') {
            if ($log->security_guard_id !== auth()->id() || $log->created_at->diffInMinutes(now()) > 60) {
                return back()->with('error', 'You can no longer edit this record.');
            }
        }

        $request->validate([
            'vehicle_number' => 'required|string',
            'house_id' => 'nullable|exists:houses,id',
            'driver_name' => 'nullable|string',
        ]);

        $vehicleNumber = strtoupper($request->vehicle_number);
        $vehicle = Vehicle::where('vehicle_number', $vehicleNumber)->first();
        $entryStatus = $vehicle ? 'verified' : 'unknown';

        $log->update([
            'vehicle_id' => $vehicle?->id,
            'vehicle_number' => $vehicleNumber,
            'house_id' => $request->house_id,
            'driver_name' => $request->driver_name,
            'entry_status' => $entryStatus,
        ]);

        return redirect()->route('security.vehicles.logs.index')->with('success', 'Vehicle log updated successfully.');
    }

    private function createAlert($vehicleNumber, $type, $reason)
    {
        VehicleAlert::create([
            'vehicle_number' => $vehicleNumber,
            'alert_type' => $type,
            'reason' => $reason,
            'security_guard_id' => auth()->id(),
            'status' => 'pending',
        ]);
    }
}
