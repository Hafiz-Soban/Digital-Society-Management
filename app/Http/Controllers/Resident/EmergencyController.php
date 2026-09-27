<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\EmergencyAlert;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class EmergencyController extends Controller
{
    public function index()
    {
        $activeAlerts = EmergencyAlert::where('status', 'active')->latest()->get();
        $pastAlerts   = EmergencyAlert::where('status', '!=', 'active')->latest()->take(10)->get();

        $emergencyContacts = [
            ['name' => 'Society Security',   'phone' => '0300-0000001', 'icon' => 'bi-shield-fill',       'color' => 'danger'],
            ['name' => 'Fire Department',     'phone' => '16',           'icon' => 'bi-fire',               'color' => 'warning'],
            ['name' => 'Ambulance / Medical', 'phone' => '1122',         'icon' => 'bi-heart-pulse-fill',   'color' => 'success'],
            ['name' => 'Police',              'phone' => '15',           'icon' => 'bi-person-badge-fill',  'color' => 'primary'],
            ['name' => 'Society Manager',     'phone' => '0300-0000002', 'icon' => 'bi-person-fill',        'color' => 'info'],
            ['name' => 'Maintenance',         'phone' => '0300-0000003', 'icon' => 'bi-tools',              'color' => 'secondary'],
        ];

        return view('resident.emergency.index', compact('activeAlerts', 'pastAlerts', 'emergencyContacts'));
    }

    public function sos(Request $request)
    {
        $request->validate([
            'type'        => 'required|in:fire,medical,security,other',
            'description' => 'required|string|max:500',
            'location'    => 'nullable|string|max:255',
        ]);

        $user     = auth()->user();
        $resident = $user->resident;

        $alert = EmergencyAlert::create([
            'created_by'  => $user->id,
            'title'       => 'SOS from ' . $user->name . ($resident?->house ? ' (House: ' . $resident->house->house_number . ')' : ''),
            'description' => $request->description,
            'type'        => $request->type,
            'severity'    => 'critical',
            'location'    => $request->location ?? ($resident?->house?->house_number ?? 'Unknown'),
            'status'      => 'active',
        ]);

        // Notify all admins and security
        $staff = User::whereHas('role', fn($q) => $q->whereIn('name', ['admin', 'security_guard']))
            ->where('status', 'active')->get();

        foreach ($staff as $member) {
            Notification::create([
                'user_id'         => $member->id,
                'title'           => '🆘 SOS ALERT from ' . $user->name,
                'message'         => $request->description,
                'type'            => 'danger',
                'icon'            => 'bi-exclamation-triangle-fill',
                'link'            => route('admin.emergency.index'),
                'notifiable_type' => EmergencyAlert::class,
                'notifiable_id'   => $alert->id,
            ]);
        }

        return back()->with('sos_sent', 'SOS alert sent! Help is on the way. Stay calm.');
    }
}
