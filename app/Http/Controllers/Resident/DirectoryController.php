<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\MaintenanceStaff;

class DirectoryController extends Controller
{
    public function index()
    {
        $admins = User::whereHas('role', fn($q) => $q->where('name', 'admin'))
            ->where('status', 'active')
            ->get();

        $securityGuards = User::whereHas('role', fn($q) => $q->where('name', 'security_guard'))
            ->where('status', 'active')
            ->get();

        $maintenanceStaff = MaintenanceStaff::where('status', '!=', 'off_duty')->get();

        $emergencyContacts = [
            ['name' => 'Fire Department',     'phone' => '16',    'type' => 'Emergency'],
            ['name' => 'Ambulance',           'phone' => '1122',  'type' => 'Emergency'],
            ['name' => 'Police',              'phone' => '15',    'type' => 'Emergency'],
            ['name' => 'Rescue',              'phone' => '1122',  'type' => 'Emergency'],
            ['name' => 'Electricity Helpline','phone' => '118',   'type' => 'Utility'],
            ['name' => 'Gas Helpline',        'phone' => '1199',  'type' => 'Utility'],
        ];

        return view('resident.directory.index', compact(
            'admins', 'securityGuards', 'maintenanceStaff', 'emergencyContacts'
        ));
    }
}
