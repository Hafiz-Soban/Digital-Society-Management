<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    public function index()
    {
        $alerts = EmergencyAlert::with('createdBy')->latest()->paginate(15);
        $activeAlerts = EmergencyAlert::where('status', 'active')->latest()->get();
        return view('security.emergency.index', compact('alerts', 'activeAlerts'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:fire,medical,security_threat,natural_disaster,other',
            'severity' => 'required|in:low,medium,high,critical',
            'location' => 'required|string|max:255',
        ]);

        $alert = EmergencyAlert::create([
            ...$request->only(['title', 'description', 'type', 'severity', 'location']),
            'created_by' => auth()->id(),
            'status' => 'active',
        ]);

        // Notify all users (Admin and Residents)
        $users = User::where('status', 'active')->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => '🚨 EMERGENCY: ' . $alert->title,
                'message' => $alert->description . ' - Location: ' . $alert->location,
                'type' => 'danger',
                'icon' => 'bi-exclamation-triangle-fill',
                'link' => route('resident.emergency.index'), // Linking to resident emergency view
                'notifiable_type' => EmergencyAlert::class,
                'notifiable_id' => $alert->id,
            ]);
        }

        return redirect()->route('security.emergency.index')
            ->with('success', 'Emergency alert broadcasted successfully to all residents and management.');
    }

    public function resolve(EmergencyAlert $alert)
    {
        $alert->update([
            'status' => 'resolved',
        ]);

        return back()->with('success', 'Emergency alert marked as resolved.');
    }
}
