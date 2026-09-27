<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;

class HouseController extends Controller
{
    public function index()
    {
        $resident = auth()->user()->resident;

        if (!$resident?->house_id) {
            return view('resident.house.no-house');
        }

        $house = $resident->house()->with([
            'maintenanceRequests' => fn($q) => $q->where('resident_id', $resident->id)->latest()->take(5),
        ])->first();

        $maintenanceHistory = $resident->maintenanceRequests()
            ->with('assignedStaff')
            ->latest()
            ->take(10)
            ->get();

        return view('resident.house.index', compact('house', 'resident', 'maintenanceHistory'));
    }
}
