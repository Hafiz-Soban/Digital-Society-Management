<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecurityLog;
use App\Models\User;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function index(Request $request)
    {
        $query = SecurityLog::with(['loggedBy', 'visitor.resident.user']);

        if ($request->search) {
            $query->where('description', 'like', '%' . $request->search . '%');
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

        $logs = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'today' => SecurityLog::whereDate('created_at', today())->count(),
            'incidents' => SecurityLog::where('event_type', 'incident')->count(),
            'critical' => SecurityLog::where('severity', 'critical')->count(),
            'total' => SecurityLog::count(),
        ];

        return view('admin.security.index', compact('logs', 'stats'));
    }
<<<<<<< HEAD

    public function destroy(SecurityLog $security)
    {
        $logId = $security->id;
        $eventType = $security->event_type;
        $data = $security->toArray();

        $security->delete();

        \App\Models\ActivityLog::create([
            'model_type' => SecurityLog::class,
            'model_id' => $logId,
            'record_name' => $eventType,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

        return back()->with('success', 'Security log deleted successfully.');
    }
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
