<?php

namespace App\Http\Controllers\Admin;

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
        
        $logs->getCollection()->transform(function ($log) {
            $log->is_editable = true; // Admin can edit all
            return $log;
        });

        return view('admin.vehicle-logs.index', compact('logs'));
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
            $this->checkSuspiciousActivity($vehicleNumber, $request->house_id);
        }

        return redirect()->back()->with('success', 'Vehicle entry recorded successfully.');
    }

    public function update(Request $request, VehicleLog $log)
    {
        $log->update(['exit_time' => now()]);
        return redirect()->back()->with('success', 'Vehicle exit recorded successfully.');
    }

    public function verify($vehicleNumber)
    {
        $vehicleNumber = strtoupper($vehicleNumber);
        $vehicle = Vehicle::with(['house', 'resident.user'])->where('vehicle_number', $vehicleNumber)->first();

        if ($vehicle) {
            return response()->json([
                'status' => 'verified',
                'house_number' => $vehicle->house->house_number,
                'owner_name' => $vehicle->resident->user->name,
                'vehicle_type' => ucfirst($vehicle->vehicle_type),
                'sticker_number' => $vehicle->sticker_number,
                'vehicle_status' => ucfirst($vehicle->status),
            ]);
        }

        // Create Unknown Vehicle Alert
        \App\Models\VehicleAlert::create([
            'vehicle_number' => $vehicleNumber,
            'alert_type' => 'unknown_vehicle',
            'reason' => 'Verification failed: Vehicle number not found in database.',
            'security_guard_id' => auth()->id(),
            'status' => 'pending',
        ]);

        return response()->json(['status' => 'unknown']);
    }

    private function checkSuspiciousActivity($vehicleNumber, $houseId)
    {
        $thirtyDaysAgo = now()->subDays(30);
        
        // 1. Same unknown vehicle enters more than 5 times within 30 days
        $recentEntriesCount = VehicleLog::where('vehicle_number', $vehicleNumber)
            ->where('entry_status', 'unknown')
            ->where('entry_time', '>=', $thirtyDaysAgo)
            ->count();

        if ($recentEntriesCount >= 5) {
            $this->createAlert($vehicleNumber, 'repeated_unknown', "Vehicle entered {$recentEntriesCount} times in the last 30 days.");
        }

        // 2. Unknown vehicle visits multiple houses
        $distinctHousesCount = VehicleLog::where('vehicle_number', $vehicleNumber)
            ->where('entry_status', 'unknown')
            ->whereNotNull('house_id')
            ->distinct('house_id')
            ->count();

        if ($distinctHousesCount > 1) {
            $this->createAlert($vehicleNumber, 'multiple_houses', "Unknown vehicle visited {$distinctHousesCount} different houses.");
        }

        // 3. Late-night entries (11 PM to 5 AM)
        $hour = now()->hour;
        if ($hour >= 23 || $hour <= 5) {
            $lateNightCount = VehicleLog::where('vehicle_number', $vehicleNumber)
                ->where('entry_status', 'unknown')
                ->where(function($q) {
                    $q->whereRaw('HOUR(entry_time) >= 23')
                      ->orWhereRaw('HOUR(entry_time) <= 5');
                })
                ->count();

            if ($lateNightCount >= 2) {
                $this->createAlert($vehicleNumber, 'late_night', "Unknown vehicle entered late at night {$lateNightCount} times.");
            }
        }
    }

    private function createAlert($vehicleNumber, $type, $reason)
    {
        // Check if an active alert already exists for this reason to avoid spam
        $exists = VehicleAlert::where('vehicle_number', $vehicleNumber)
            ->where('alert_type', $type)
            ->where('status', 'pending')
            ->where('created_at', '>=', now()->subDay())
            ->exists();

        if (!$exists) {
            VehicleAlert::create([
                'vehicle_number' => $vehicleNumber,
                'alert_type' => $type,
                'reason' => $reason,
                'security_guard_id' => auth()->id(),
                'status' => 'pending',
            ]);
        }
    }
}
