<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\Resident;
use App\Models\House;
use App\Models\Complaint;
use App\Models\ComplaintCategory;
use App\Models\MaintenanceRequest;
use App\Models\Visitor;
use App\Models\Notice;
use App\Models\EmergencyAlert;
use App\Models\Notification;
use App\Models\MaintenanceStaff;
use App\Models\SecurityIncident;
use App\Models\SecurityLog;
use App\Models\ComplaintLog;
use App\Models\MaintenanceLog;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class ResidentPortalSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Roles
        $residentRole = Role::firstOrCreate(['name' => 'resident'], ['display_name' => 'Resident']);
        $adminRole = Role::firstOrCreate(['name' => 'admin'], ['display_name' => 'Administrator']);
        $securityRole = Role::firstOrCreate(['name' => 'security_guard'], ['display_name' => 'Security Guard']);

        // 2. Users
        $residentUser = User::updateOrCreate(
            ['email' => 'resident@example.com'],
            [
                'name' => 'John Doe',
                'password' => Hash::make('password'),
                'role_id' => $residentRole->id,
                'status' => 'active',
                'phone' => '0300-1234567'
            ]
        );

        $adminUser = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role_id' => $adminRole->id,
                'status' => 'active',
            ]
        );

        $securityUser = User::updateOrCreate(
            ['email' => 'security@example.com'],
            [
                'name' => 'Security Officer Mike',
                'password' => Hash::make('password'),
                'role_id' => $securityRole->id,
                'status' => 'active',
                'phone' => '0300-9998887'
            ]
        );

        // 3. House
        $house = House::updateOrCreate(
            ['house_number' => 'H-101'],
            [
                'block' => 'A',
                'floor' => 'Ground',
<<<<<<< HEAD
                'type' => 'apartment',
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                'bedrooms' => 3,
                'area_sqft' => 1500,
                'monthly_maintenance' => 5000,
                'status' => 'occupied'
            ]
        );

        // 4. Resident
        $resident = Resident::updateOrCreate(
            ['user_id' => $residentUser->id],
            [
                'house_id' => $house->id,
                'resident_id' => 'RES-0001',
                'cnic' => '42101-1234567-1',
                'gender' => 'male',
                'ownership_type' => 'owner',
                'status' => 'active',
                'move_in_date' => Carbon::now()->subMonths(6),
                'emergency_contact_name' => 'Jane Doe',
                'emergency_contact_phone' => '0300-7654321',
                'emergency_contact_relation' => 'Spouse'
            ]
        );

        // 5. Complaint Categories
        $cat1 = ComplaintCategory::firstOrCreate(['name' => 'Security'], ['icon' => 'bi-shield-lock', 'color' => '#dc3545', 'is_active' => true]);
        $cat2 = ComplaintCategory::firstOrCreate(['name' => 'Cleanliness'], ['icon' => 'bi-trash', 'color' => '#198754', 'is_active' => true]);
        $cat3 = ComplaintCategory::firstOrCreate(['name' => 'Utility'], ['icon' => 'bi-plug', 'color' => '#0dcaf0', 'is_active' => true]);

        // 6. Complaints
        $cmp1 = Complaint::updateOrCreate(
            ['complaint_number' => 'CMP-0001'],
            [
                'resident_id' => $resident->id,
                'category_id' => $cat1->id,
                'title' => 'Street light not working',
                'description' => 'The street light in front of my house has been out for 3 days. It is very dark at night.',
                'priority' => 'medium',
                'status' => 'resolved',
                'resolution_notes' => 'Bulb replaced by maintenance team.',
                'resolved_at' => Carbon::now()->subDays(2)
            ]
        );

        ComplaintLog::firstOrCreate(
            ['complaint_id' => $cmp1->id, 'status' => 'pending'],
            ['user_id' => $residentUser->id, 'comment' => 'Complaint submitted by resident.', 'created_at' => $cmp1->created_at]
        );

        ComplaintLog::firstOrCreate(
            ['complaint_id' => $cmp1->id, 'status' => 'resolved'],
            ['user_id' => $adminUser->id, 'comment' => 'Bulb replaced by maintenance team.', 'created_at' => $cmp1->resolved_at]
        );

        // 7. Maintenance Staff
        $staff = MaintenanceStaff::updateOrCreate(
            ['name' => 'Ahmed Khan'],
            ['specialization' => 'plumbing', 'phone' => '0311-1111111', 'status' => 'available']
        );

        // 8. Maintenance Requests
        $mnt1 = MaintenanceRequest::updateOrCreate(
            ['request_number' => 'MNT-0001'],
            [
                'resident_id' => $resident->id,
                'house_id' => $house->id,
                'title' => 'Kitchen Tap Repair',
                'description' => 'The kitchen tap is leaking constantly.',
                'category' => 'plumbing',
                'priority' => 'low',
                'status' => 'completed',
                'assigned_staff_id' => $staff->id,
                'completed_at' => Carbon::now()->subDay()
            ]
        );

        MaintenanceLog::firstOrCreate(
            ['maintenance_request_id' => $mnt1->id, 'status' => 'pending'],
            ['user_id' => $residentUser->id, 'comment' => 'Maintenance request submitted by resident.']
        );

        // 9. Visitors
        Visitor::updateOrCreate(
            ['visitor_name' => 'Mohammad Ali', 'resident_id' => $resident->id],
            [
                'visitor_phone' => '0322-2222222',
                'purpose' => 'Family Visit',
                'status' => 'checked_out',
                'expected_arrival' => Carbon::now()->subDays(1)->setHour(18),
                'actual_arrival' => Carbon::now()->subDays(1)->setHour(18)->addMinutes(15),
                'departure_time' => Carbon::now()->subDays(1)->setHour(21)
            ]
        );

        // 10. Notices
        Notice::updateOrCreate(
            ['title' => 'Annual Society Meeting'],
            [
                'created_by' => $adminUser->id,
                'content' => 'The annual general meeting for all residents will be held this Sunday at 4 PM in the Community Hall. Attendance is mandatory.',
                'type' => 'announcement',
                'priority' => 'high',
                'is_published' => true,
                'publish_at' => Carbon::now()->subDays(1)
            ]
        );

        // 11. Security Incidents
        SecurityIncident::updateOrCreate(
            ['title' => 'Suspicious Vehicle near Gate 2'],
            [
                'reported_by' => $securityUser->id,
                'type' => 'unauthorized_access',
                'description' => 'A black sedan was seen circling Gate 2 multiple times without entering. License plate partially identified.',
                'location' => 'Gate 2',
                'status' => 'under_review'
            ]
        );

        // 12. Security Logs
        SecurityLog::updateOrCreate(
            ['event_type' => 'patrol', 'location' => 'Sector A & B'],
            [
                'logged_by' => $securityUser->id,
                'description' => 'Completed morning patrol of Sector A and B. Everything normal.',
                'severity' => 'info'
            ]
        );
    }
}
