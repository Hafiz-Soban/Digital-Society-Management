@extends('layouts.resident')
@section('title', 'Notifications')
@section('page-title', 'Notifications')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Recent Notifications</h5>
                <p class="text-muted small mb-0">Stay updated with the latest society activities</p>
            </div>
            <div class="d-flex gap-2">
                @if($unreadCount > 0)
                <form action="{{ route('resident.notifications.read-all') }}" method="POST">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-primary btn-sm rounded-pill px-3">
                        <i class="bi bi-check2-all me-1"></i> Mark all as read
                    </button>
                </form>
                @endif
                <div class="dropdown">
                    <button class="btn btn-light btn-sm rounded-pill px-3 dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-filter me-1"></i> {{ request('filter') == 'unread' ? 'Unread Only' : 'All Notifications' }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><a class="dropdown-item" href="{{ route('resident.notifications.index') }}">All Notifications</a></li>
                        <li><a class="dropdown-item" href="{{ route('resident.notifications.index', ['filter' => 'unread']) }}">Unread Only</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="list-group list-group-flush">
                @forelse($notifications as $notification)
                <div class="list-group-item p-4 {{ $notification->is_read ? 'bg-white' : 'bg-light bg-opacity-50' }} border-start-4 border-{{ $notification->type ?? 'primary' }} position-relative transition hover-bg">
                    <div class="d-flex gap-3">
                        <div class="flex-shrink-0">
                            <div class="bg-{{ $notification->type ?? 'primary' }} bg-opacity-10 text-{{ $notification->type ?? 'primary' }} rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">
                                <i class="bi {{ $notification->icon ?? 'bi-bell' }} fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1">
                            <div class="d-flex justify-content-between align-items-start mb-1">
                                <h6 class="fw-bold mb-0 text-dark">{{ $notification->title }}</h6>
                                <span class="text-muted small" style="font-size:.75rem">{{ $notification->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-muted small mb-3">{{ $notification->message }}</p>

                            <div class="d-flex align-items-center gap-3">
                                @if($notification->link)
                                <a href="{{ $notification->link }}" class="btn btn-sm btn-outline-{{ $notification->type ?? 'primary' }} rounded-pill px-3">
                                    View Details <i class="bi bi-arrow-right ms-1"></i>
                                </a>
                                @endif

                                @if(!$notification->is_read)
                                <form action="{{ route('resident.notifications.read', $notification) }}" method="POST">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-link btn-sm text-decoration-none p-0 text-muted">
                                        Mark as read
                                    </button>
                                </form>
                                @endif

                                <form action="{{ route('resident.notifications.destroy', $notification) }}" method="POST" class="ms-auto">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-link btn-sm text-decoration-none p-0 text-danger opacity-50 hover-opacity-100" title="Delete notification">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @if(!$notification->is_read)
                    <div class="position-absolute top-0 end-0 p-2">
                        <span class="p-1 bg-{{ $notification->type ?? 'primary' }} border border-light rounded-circle"></span>
                    </div>
                    @endif
                </div>
                @empty
                <div class="p-5 text-center text-muted">
                    <div class="mb-3"><i class="bi bi-bell-slash display-4 opacity-25"></i></div>
                    <h5>No notifications found.</h5>
                    <p class="small mb-0">You're all caught up!</p>
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
.hover-bg:hover { background-color: rgba(0,0,0,0.02) !important; }
.transition { transition: all 0.2s ease-in-out; }
.hover-opacity-100:hover { opacity: 1 !important; }
</style>
@endsection
