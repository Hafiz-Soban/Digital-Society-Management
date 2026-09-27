<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VehicleAlert;
use Illuminate\Http\Request;

class VehicleAlertController extends Controller
{
    public function index(Request $request)
    {
        $query = VehicleAlert::with('securityGuard');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $alerts = $query->latest()->paginate(15);
        return view('admin.vehicle-alerts.index', compact('alerts'));
    }

    public function resolve(VehicleAlert $alert)
    {
        $alert->update(['status' => 'resolved']);
        return redirect()->back()->with('success', 'Alert marked as resolved.');
    }
}
