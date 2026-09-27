<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;

class EmergencyContactController extends Controller
{
    public function index()
    {
        $contacts = EmergencyContact::orderBy('priority_level', 'asc')->get();
        return view('admin.emergency_contacts.index', compact('contacts'));
    }

    public function create()
    {
        return view('admin.emergency_contacts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'designation' => 'required|string|max:255',
            'priority_level' => 'required|integer|min:1|max:10',
        ]);

        EmergencyContact::create($validated);

        return redirect()->route('admin.emergency_contacts.index')->with('success', 'Emergency contact added.');
    }

    public function edit(EmergencyContact $emergencyContact)
    {
        return view('admin.emergency_contacts.edit', compact('emergencyContact'));
    }

    public function update(Request $request, EmergencyContact $emergencyContact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'designation' => 'required|string|max:255',
            'priority_level' => 'required|integer|min:1|max:10',
        ]);

        $emergencyContact->update($validated);

        return redirect()->route('admin.emergency_contacts.index')->with('success', 'Emergency contact updated.');
    }

    public function destroy(EmergencyContact $emergencyContact)
    {
        $emergencyContact->delete();
        return redirect()->route('admin.emergency_contacts.index')->with('success', 'Emergency contact deleted.');
    }
}
