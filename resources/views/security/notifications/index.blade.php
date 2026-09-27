@extends('layouts.security')
@section('title', 'Notifications')
@section('page-title', 'My Notifications')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Recent Notifications</h5>
                <p class="text-muted small mb-0">You have {{ $unreadCount }} unread notifications</p>
            </div>
            <div class="d-flex gap-2">
                @if($unreadCount > 0)
                <form action="{{ route('security.notifications.read-all') }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                        Mark all as read
                    </button>
                </form>
                @endif
                <div class="dropdown">
                    <button class="btn btn-sm btn-light border dropdown-toggle px-3 rounded-pill" data-bs-toggle="dropdown">
                        <i class="bi bi-filter me-1"></i> Filter
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="{{ route('security.notifications.index') }}">All Notifications</a></li>
                        <li><a class="dropdown-item" href="{{ route('security.notifications.index', ['filter' => 'unread']) }}">Unread Only</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 overflow-hidden">
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                <div class="list-group-item p-4 {{ $notification->is_read ? 'bg-white' : 'bg-light bg-opacity-50' }} border-start-4 border-{{ $notification->type ?? 'primary' }}">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $notification->type ?? 'primary' }} bg-opacity-10 text-{{ $notification->type ?? 'primary' }} rounded-circle d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                                <i class="bi {{ $notification->icon ?? 'bi-bell' }} fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-dark">{{ $notification->title }}</h6>
                                <span class="text-muted small">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-secondary small mb-3">{{ $notification->message }}</p>
                            
                            <div class="d-flex gap-3 align-items-center">
                                @if($notification->link)
                                <a href="{{ $notification->link }}" class="btn btn-sm btn-outline-{{ $notification->type ?? 'primary' }} rounded-pill px-3">
                                    View Details
                                </a>
                                @endif
                                
                                @if(!$notification->is_read)
                                <form action="{{ route('security.notifications.read', $notification) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-link btn-sm text-muted text-decoration-none p-0">Mark as read</button>
                                </form>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @empty
                <div class="p-5 text-center text-muted">
                    <div class="mb-3"><i class="bi bi-bell-slash display-4 opacity-25"></i></div>
                    <h5>No notifications found.</h5>
                </div>
                @endforelse
            </div>
        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</div>

<style>
.border-start-4 { border-left-width: 4px !important; }
</style>
@endsection
