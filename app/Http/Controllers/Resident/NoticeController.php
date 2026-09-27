<?php

namespace App\Http\Controllers\Resident;

use App\Http\Controllers\Controller;
use App\Models\Notice;
<<<<<<< HEAD
use App\Models\NoticeRead;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
<<<<<<< HEAD
        $user = auth()->user();
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        $query = Notice::published();

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('content', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        if ($request->priority) {
            $query->where('priority', $request->priority);
        }

<<<<<<< HEAD
        $notices = $query->latest()->get()->filter(fn($notice) => $notice->isTargetedToUser($user));
        
        // Re-paginate manually
        $page = request()->page ?? 1;
        $perPage = 10;
        $notices = new \Illuminate\Pagination\LengthAwarePaginator(
            $notices->forPage($page, $perPage),
            $notices->count(),
            $perPage,
            $page,
            ['path' => request()->url(), 'query' => request()->query()]
        );
=======
        $notices = $query->latest()->paginate(10)->withQueryString();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

        return view('resident.notices.index', compact('notices'));
    }

    public function show(Notice $notice)
    {
<<<<<<< HEAD
        $user = auth()->user();
        
        if (!$notice->is_published || !$notice->isTargetedToUser($user)) {
            abort(404);
        }
        
        // Track read status
        NoticeRead::firstOrCreate([
            'notice_id' => $notice->id,
            'user_id' => $user->id,
        ], [
            'read_at' => now()
        ]);
        
        // Update notice read count
        $readCount = $notice->reads()->count();
        $notice->update(['read_count' => $readCount]);

=======
        if (!$notice->is_published) {
            abort(404);
        }
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return view('resident.notices.show', compact('notice'));
    }
}
