<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Notification;
use App\Models\User;
<<<<<<< HEAD
use App\Models\House;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Illuminate\Http\Request;

class NoticeController extends Controller
{
    public function index(Request $request)
    {
        $query = Notice::with('createdBy');

        if ($request->search) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->type) {
            $query->where('type', $request->type);
        }

        $notices = $query->latest()->paginate(15)->withQueryString();
        return view('admin.notices.index', compact('notices'));
    }

    public function create()
    {
<<<<<<< HEAD
        $blocks = House::select('block')->distinct()->orderBy('block')->pluck('block')->filter();
        $houses = House::with('currentResident')->orderBy('block')->get();
        $users = User::where('status', 'active')->orderBy('name')->get();
        
        return view('admin.notices.create', compact('blocks', 'houses', 'users'));
=======
        return view('admin.notices.create');
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
<<<<<<< HEAD
            'type' => 'required|in:notice,announcement,alert,event,general,maintenance,emergency,rule',
            'priority' => 'required|in:low,normal,high,urgent',
            'target_type' => 'required|in:all,block,house,residents,security,staff,custom',
            'target_blocks' => 'nullable|array',
            'target_houses' => 'nullable|array',
            'target_users' => 'nullable|array',
=======
            'type' => 'required|in:notice,announcement,alert,event',
            'priority' => 'required|in:low,normal,high,urgent',
            'target_audience' => 'required|in:all,residents,security,maintenance',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'publish_at' => 'nullable|date',
            'expires_at' => 'nullable|date|after:publish_at',
        ]);

        $notice = Notice::create([
<<<<<<< HEAD
            ...$request->only([
                'title', 'content', 'type', 'priority', 'target_audience', 
                'publish_at', 'expires_at', 
                'target_type', 'target_blocks', 'target_houses', 'target_users'
            ]),
=======
            ...$request->only(['title', 'content', 'type', 'priority', 'target_audience', 'publish_at', 'expires_at']),
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'created_by' => auth()->id(),
            'is_published' => $request->boolean('is_published'),
        ]);

<<<<<<< HEAD
=======
        // Send notifications to users
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        if ($notice->is_published) {
            $this->sendNotifications($notice);
        }

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice created successfully.');
    }

<<<<<<< HEAD
    public function show(Notice $notice)
    {
        $notice->load('createdBy', 'readByUsers');
        return view('admin.notices.show', compact('notice'));
    }

    public function edit(Notice $notice)
    {
        $blocks = House::select('block')->distinct()->orderBy('block')->pluck('block')->filter();
        $houses = House::with('currentResident')->orderBy('block')->get();
        $users = User::where('status', 'active')->orderBy('name')->get();
        return view('admin.notices.edit', compact('notice', 'blocks', 'houses', 'users'));
=======
    public function edit(Notice $notice)
    {
        return view('admin.notices.edit', compact('notice'));
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }

    public function update(Request $request, Notice $notice)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
<<<<<<< HEAD
            'type' => 'required|in:notice,announcement,alert,event,general,maintenance,emergency,rule',
            'priority' => 'required|in:low,normal,high,urgent',
            'target_type' => 'required|in:all,block,house,residents,security,staff,custom',
            'target_blocks' => 'nullable|array',
            'target_houses' => 'nullable|array',
            'target_users' => 'nullable|array',
=======
            'type' => 'required|in:notice,announcement,alert,event',
            'priority' => 'required|in:low,normal,high,urgent',
            'target_audience' => 'required|in:all,residents,security,maintenance',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        ]);

        $wasPublished = $notice->is_published;
        $notice->update([
<<<<<<< HEAD
            ...$request->only([
                'title', 'content', 'type', 'priority', 'target_audience', 
                'publish_at', 'expires_at',
                'target_type', 'target_blocks', 'target_houses', 'target_users'
            ]),
=======
            ...$request->only(['title', 'content', 'type', 'priority', 'target_audience', 'publish_at', 'expires_at']),
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            'is_published' => $request->boolean('is_published'),
        ]);

        if (!$wasPublished && $notice->is_published) {
            $this->sendNotifications($notice);
        }

        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice updated successfully.');
    }

    public function destroy(Notice $notice)
    {
<<<<<<< HEAD
        $noticeId = $notice->id;
        $noticeTitle = $notice->title;
        $data = $notice->toArray();

        $notice->delete();

        \App\Models\ActivityLog::create([
            'model_type' => Notice::class,
            'model_id' => $noticeId,
            'record_name' => $noticeTitle,
            'action' => 'deleted',
            'user_id' => \Illuminate\Support\Facades\Auth::id(),
            'data' => $data
        ]);

=======
        $notice->delete();
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        return redirect()->route('admin.notices.index')
            ->with('success', 'Notice deleted successfully.');
    }

    private function sendNotifications(Notice $notice): void
    {
<<<<<<< HEAD
        $users = User::where('status', 'active')->get();
        $targetedUsers = $users->filter(fn($u) => $notice->isTargetedToUser($u));
        
        $notice->update(['delivery_count' => $targetedUsers->count()]);

        foreach ($targetedUsers as $user) {
=======
        $query = User::query();

        if ($notice->target_audience === 'residents') {
            $query->whereHas('role', fn($q) => $q->where('name', 'resident'));
        } elseif ($notice->target_audience === 'security') {
            $query->whereHas('role', fn($q) => $q->where('name', 'security_guard'));
        }

        $users = $query->where('status', 'active')->get();

        foreach ($users as $user) {
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            Notification::create([
                'user_id' => $user->id,
                'title' => 'New ' . ucfirst($notice->type) . ': ' . $notice->title,
                'message' => substr(strip_tags($notice->content), 0, 150) . '...',
                'type' => $notice->priority === 'urgent' ? 'danger' : 'info',
                'icon' => 'bi-megaphone',
                'link' => '#',
                'notifiable_type' => Notice::class,
                'notifiable_id' => $notice->id,
            ]);
        }
    }
}
