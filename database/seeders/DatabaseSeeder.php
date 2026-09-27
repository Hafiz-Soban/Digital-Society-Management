<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Permission;
use App\Models\User;
use App\Models\House;
use App\Models\Resident;
use App\Models\ComplaintCategory;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Roles
        $adminRole = Role::create(['name' => 'admin', 'display_name' => 'Administrator', 'description' => 'Full system access']);
        $residentRole = Role::create(['name' => 'resident', 'display_name' => 'Resident', 'description' => 'Resident access']);
        $securityRole = Role::create(['name' => 'security_guard', 'display_name' => 'Security Guard', 'description' => 'Security access']);

        // Create Permissions
        $modules = [
            'residents' => ['view', 'create', 'edit', 'delete'],
            'houses' => ['view', 'create', 'edit', 'delete'],
            'visitors' => ['view', 'create', 'edit', 'approve'],
            'complaints' => ['view', 'create', 'edit', 'delete', 'assign'],
            'maintenance' => ['view', 'create', 'edit', 'delete', 'assign'],
            'notices' => ['view', 'create', 'edit', 'delete'],
            'emergency' => ['view', 'create', 'resolve'],
            'security' => ['view', 'create', 'manage'],
            'reports' => ['view', 'export'],
            'settings' => ['view', 'manage'],
        ];

        $allPermissions = [];
        foreach ($modules as $module => $actions) {
            foreach ($actions as $action) {
                $perm = Permission::create([
                    'name' => $module . '.' . $action,
                    'display_name' => ucfirst($action) . ' ' . ucfirst($module),
                    'module' => $module,
                ]);
                $allPermissions[] = $perm->id;
            }
        }

        // Admin gets all permissions
        $adminRole->permissions()->attach($allPermissions);

        // Resident permissions
        $residentPermissions = Permission::whereIn('name', [
            'visitors.view', 'visitors.create',
            'complaints.view', 'complaints.create',
            'maintenance.view', 'maintenance.create',
            'notices.view',
            'emergency.view',
        ])->pluck('id');
        $residentRole->permissions()->attach($residentPermissions);

        // Security Guard permissions
        $securityPermissions = Permission::whereIn('name', [
            'visitors.view', 'visitors.create', 'visitors.approve',
            'security.view', 'security.create',
            'emergency.view', 'emergency.create',
            'notices.view',
        ])->pluck('id');
        $securityRole->permissions()->attach($securityPermissions);

        // Create Admin User
        $admin = User::create([
            'role_id' => $adminRole->id,
            'name' => 'System Administrator',
<<<<<<< HEAD
            'email' => 'admin@example.com',
=======
            'email' => 'admin@society.com',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'phone' => '+92-300-0000001',
            'password' => Hash::make('admin123'),
            'status' => 'active',
        ]);

        // Create sample houses
        $houses = [];
        for ($i = 1; $i <= 20; $i++) {
            $houses[] = House::create([
                'house_number' => 'A-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'block' => 'A',
                'floor' => ceil($i / 4),
                'bedrooms' => rand(2, 4),
                'area_sqft' => rand(800, 2000),
                'monthly_maintenance' => rand(2000, 5000),
                'status' => $i <= 15 ? 'occupied' : 'vacant',
<<<<<<< HEAD
                'is_rented' => 'no',
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            ]);
        }

        // Create sample resident user
        $residentUser = User::create([
            'role_id' => $residentRole->id,
            'name' => 'Ahmed Khan',
<<<<<<< HEAD
            'email' => 'resident@example.com',
=======
            'email' => 'resident@society.com',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'phone' => '+92-300-1234567',
            'password' => Hash::make('resident123'),
            'status' => 'active',
        ]);

        Resident::create([
            'user_id' => $residentUser->id,
            'house_id' => $houses[0]->id,
            'resident_id' => 'RES-001',
            'cnic' => '42101-1234567-1',
            'date_of_birth' => '1985-05-15',
            'gender' => 'male',
            'emergency_contact_name' => 'Sara Khan',
            'emergency_contact_phone' => '+92-300-9876543',
            'emergency_contact_relation' => 'Spouse',
            'move_in_date' => '2023-01-01',
            'ownership_type' => 'owner',
            'status' => 'active',
            'family_members' => 4,
        ]);

        // Create security guard user
        $securityUser = User::create([
            'role_id' => $securityRole->id,
            'name' => 'Imran Ali',
<<<<<<< HEAD
            'email' => 'security@example.com',
=======
            'email' => 'security@society.com',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'phone' => '+92-300-7654321',
            'password' => Hash::make('security123'),
            'status' => 'active',
        ]);

        // Create complaint categories
        $categories = [
            ['name' => 'Water Supply', 'icon' => 'bi-droplet', 'color' => '#0dcaf0'],
            ['name' => 'Electricity', 'icon' => 'bi-lightning', 'color' => '#ffc107'],
            ['name' => 'Garbage Collection', 'icon' => 'bi-trash', 'color' => '#198754'],
            ['name' => 'Parking', 'icon' => 'bi-car-front', 'color' => '#6c757d'],
            ['name' => 'Security', 'icon' => 'bi-shield', 'color' => '#dc3545'],
            ['name' => 'Noise Complaint', 'icon' => 'bi-volume-up', 'color' => '#fd7e14'],
            ['name' => 'Lift/Elevator', 'icon' => 'bi-arrow-up-square', 'color' => '#6610f2'],
            ['name' => 'Common Area', 'icon' => 'bi-building', 'color' => '#0d6efd'],
            ['name' => 'Other', 'icon' => 'bi-three-dots', 'color' => '#adb5bd'],
        ];

        foreach ($categories as $cat) {
            ComplaintCategory::create($cat);
        }
    }
}
