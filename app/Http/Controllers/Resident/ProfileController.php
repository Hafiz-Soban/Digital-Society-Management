<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function show()
    {
        $user     = auth()->user();
        $resident = $user->resident?->load('house');
        return view('resident.profile.show', compact('user', 'resident'));
    }

    public function edit()
    {
        $user     = auth()->user();
        $resident = $user->resident?->load('house');
        return view('resident.profile.edit', compact('user', 'resident'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'name'                       => 'required|string|max:255',
            'phone'                      => 'nullable|string|max:20',
            'avatar'                     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'emergency_contact_name'     => 'nullable|string|max:255',
            'emergency_contact_phone'    => 'nullable|string|max:20',
            'emergency_contact_relation' => 'nullable|string|max:100',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->update(['avatar' => $path]);
        }

        $user->update([
            'name'  => $request->name,
            'phone' => $request->phone,
        ]);

        if ($user->resident) {
            $user->resident->update([
                'emergency_contact_name'     => $request->emergency_contact_name,
                'emergency_contact_phone'    => $request->emergency_contact_phone,
                'emergency_contact_relation' => $request->emergency_contact_relation,
            ]);
        }

        return redirect()->route('resident.profile.show')
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password'         => ['required', 'confirmed', Password::min(8)],
        ]);

        if (!Hash::check($request->current_password, auth()->user()->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        auth()->user()->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }

    public function settings()
    {
        $user = auth()->user();
        return view('resident.profile.settings', compact('user'));
    }
}
