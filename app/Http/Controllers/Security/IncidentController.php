<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\SecurityIncident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $query = SecurityIncident::with('reporter');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $incidents = $query->latest()->paginate(15)->withQueryString();

        return view('security.incidents.index', compact('incidents'));
    }

    public function create()
    {
        return view('security.incidents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:theft,property_damage,unauthorized_access,security_violation,other',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('incidents', 'public');
        }

        SecurityIncident::create([
            ...$request->except('image'),
            'reported_by' => auth()->id(),
            'image' => $imagePath,
            'status' => 'reported',
        ]);

        return redirect()->route('security.incidents.index')
            ->with('success', 'Incident reported successfully.');
    }

    public function show(SecurityIncident $incident)
    {
        $incident->load('reporter');
        return view('security.incidents.show', compact('incident'));
    }

    public function updateStatus(Request $request, SecurityIncident $incident)
    {
        $request->validate([
            'status' => 'required|in:under_review,resolved',
            'resolution_notes' => 'required_if:status,resolved|nullable|string',
        ]);

        $data = [
            'status' => $request->status,
        ];

        if ($request->status === 'resolved') {
            $data['resolved_at'] = now();
            $data['resolution_notes'] = $request->resolution_notes;
        }

        $incident->update($data);

        return back()->with('success', 'Incident status updated successfully.');
    }
}
