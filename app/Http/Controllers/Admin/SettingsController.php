<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        $users = User::with('role')->latest()->paginate(15);
        $roles = Role::all();
        $requireApproval = Setting::get('require_admin_approval', 'no');
<<<<<<< HEAD
        return view('admin.settings.index', compact('users', 'roles', 'requireApproval'));
=======
        $maintenanceRestriction = Setting::get('maintenance_restriction_enabled', '0');
        return view('admin.settings.index', compact('users', 'roles', 'requireApproval', 'maintenanceRestriction'));
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function updateRegistrationSettings(Request $request)
    {
        $request->validate([
            'require_admin_approval' => 'required|in:yes,no',
        ]);

        Setting::set('require_admin_approval', $request->require_admin_approval);

        return back()->with('success', 'Registration settings updated successfully.');
    }

<<<<<<< HEAD
=======
    public function updateMaintenanceRestriction(Request $request)
    {
        $request->validate([
            'maintenance_restriction_enabled' => 'required|in:1,0',
        ]);

        Setting::set('maintenance_restriction_enabled', $request->maintenance_restriction_enabled);

        return back()->with('success', 'Maintenance restriction setting updated successfully.');
    }

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    public function createUser()
    {
        $roles = Role::all();
        return view('admin.settings.create-user', compact('roles'));
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'password' => 'required|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        return redirect()->route('admin.settings.index')
            ->with('success', 'User created successfully.');
    }

    public function updateUserStatus(Request $request, User $user)
    {
        $request->validate(['status' => 'required|in:active,inactive,suspended']);
        $user->update(['status' => $request->status]);
        return back()->with('success', 'User status updated.');
    }

    public function destroyUser(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }
        $user->delete();
        return back()->with('success', 'User deleted successfully.');
    }
}
