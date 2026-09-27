<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Resident;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index(Request $request)
    {
        $query = Visitor::with(['resident.user', 'approvedBy']);

        if ($request->search) {
            $query->where('visitor_name', 'like', '%' . $request->search . '%')
                  ->orWhere('visitor_phone', 'like', '%' . $request->search . '%')
                  ->orWhere('vehicle_number', 'like', '%' . $request->search . '%');
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $visitors = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'today' => Visitor::whereDate('created_at', today())->count(),
            'pending' => Visitor::where('status', 'pending')->count(),
            'checked_in' => Visitor::where('status', 'checked_in')->count(),
            'total' => Visitor::count(),
        ];

        return view('admin.visitors.index', compact('visitors', 'stats'));
    }

    public function show(Visitor $visitor)
    {
        $visitor->load(['resident.user', 'approvedBy', 'securityLogs.loggedBy']);
        return view('admin.visitors.show', compact('visitor'));
    }

    public function updateStatus(Request $request, Visitor $visitor)
    {
        $request->validate([
            'status' => 'required|in:approved,denied,checked_in,checked_out',
        ]);

        $data = ['status' => $request->status];

        if ($request->status === 'checked_in') {
            $data['actual_arrival'] = now();
            $data['approved_by'] = auth()->id();
        } elseif ($request->status === 'checked_out') {
            $data['departure_time'] = now();
        }

        $visitor->update($data);

        return back()->with('success', 'Visitor status updated successfully.');
    }
<<<<<<< HEAD

    public function destroy(Visitor $visitor)
    {
        $visitorId = $visitor->id;
        $visitorName = $visitor->visitor_name;
        $data = $visitor->toArray();

        $visitor->delete();

        \App\Models\ActivityLog::create([
            'model_type' => Visitor::class,
            'model_id' => $visitorId,
            'record_name' => $visitorName,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

        return back()->with('success', 'Visitor record deleted successfully.');
    }
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
