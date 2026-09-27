<?php

namespace App\Http\Controllers\Security;

use App\Http\Controllers\Controller;
use App\Models\SecurityLog;
use Illuminate\Http\Request;

class SecurityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = SecurityLog::with(['loggedBy', 'visitor']);

        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%')
                  ->orWhere('location', 'like', '%' . $request->search . '%');
        }

        if ($request->event_type) {
            $query->where('event_type', $request->event_type);
        }

        if ($request->severity) {
            $query->where('severity', $request->severity);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->latest()->paginate(25)->withQueryString();
        return view('security.logs.index', compact('logs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'event_type' => 'required|in:visitor_entry,visitor_exit,incident,patrol,alert,other',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'severity' => 'required|in:info,warning,critical',
        ]);

        SecurityLog::create([
            ...$request->all(),
            'logged_by' => auth()->id(),
        ]);

        return redirect()->route('security.logs.index')
            ->with('success', 'Security log recorded successfully.');
    }
}
