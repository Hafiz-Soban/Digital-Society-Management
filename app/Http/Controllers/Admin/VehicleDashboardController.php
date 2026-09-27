<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Vehicle;
use App\Models\VehicleLog;
use App\Models\VehicleAlert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VehicleDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_vehicles' => Vehicle::count(),
            'active_vehicles' => Vehicle::where('status', 'active')->count(),
            'inactive_vehicles' => Vehicle::where('status', 'inactive')->count(),
            'unknown_entries' => VehicleLog::where('entry_status', 'unknown')->count(),
            'suspicious_alerts' => VehicleAlert::where('status', 'pending')->count(),
        ];

        $recentLogs = VehicleLog::with(['vehicle', 'house'])->latest()->take(10)->get();
        
        $vehicleTypes = Vehicle::select('vehicle_type', DB::raw('count(*) as count'))
            ->groupBy('vehicle_type')
            ->get();

        return view('admin.vehicles.dashboard', compact('stats', 'recentLogs', 'vehicleTypes'));
    }
}
