<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    public function index(Request $request)
    {
        $query = EmergencyAlert::with('createdBy');

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $alerts = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'active' => EmergencyAlert::where('status', 'active')->count(),
            'resolved' => EmergencyAlert::where('status', 'resolved')->count(),
            'total' => EmergencyAlert::count(),
        ];

        return view('admin.emergency.index', compact('alerts', 'stats'));
    }

    public function create()
    {
        return view('admin.emergency.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'type' => 'required|in:fire,medical,security,natural_disaster,power_outage,other',
            'severity' => 'required|in:low,medium,high,critical',
            'location' => 'nullable|string|max:255',
        ]);

        $alert = EmergencyAlert::create([
            ...$request->only(['title', 'description', 'type', 'severity', 'location']),
            'created_by' => auth()->id(),
            'status' => 'active',
        ]);

        // Notify all active users
        $users = User::where('status', 'active')->get();
        foreach ($users as $user) {
            Notification::create([
                'user_id' => $user->id,
                'title' => '🚨 EMERGENCY ALERT: ' . $alert->title,
                'message' => $alert->description,
                'type' => 'danger',
                'icon' => 'bi-exclamation-triangle',
                'link' => '#',
                'notifiable_type' => EmergencyAlert::class,
                'notifiable_id' => $alert->id,
            ]);
        }

        return redirect()->route('admin.emergency.index')
            ->with('success', 'Emergency alert created and all users notified.');
    }

    public function resolve(Request $request, EmergencyAlert $alert)
    {
        $request->validate([
            'resolution_notes' => 'required|string',
            'status' => 'required|in:resolved,false_alarm',
        ]);

        $alert->update([
            'status' => $request->status,
            'resolution_notes' => $request->resolution_notes,
            'resolved_at' => now(),
        ]);

        return back()->with('success', 'Emergency alert resolved.');
    }
}
