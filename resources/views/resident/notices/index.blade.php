@extends('layouts.resident')
@section('title', 'Notice Board')
@section('page-title', 'Notice Board')

@section('content')
<div class="row g-4">
    {{-- Search and Filter --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('resident.notices.index') }}" method="GET" class="row g-3">
                    <div class="col-md-5">
                        <div class="input-group">
                            <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                            <input type="text" name="search" class="form-control border-start-0"
                                   placeholder="Search notices..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="announcement" {{ request('type') == 'announcement' ? 'selected' : '' }}>Announcements</option>
                            <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Events</option>
                            <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                            <option value="rule" {{ request('type') == 'rule' ? 'selected' : '' }}>Rules & Regs</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="priority" class="form-select">
                            <option value="">All Priorities</option>
                            <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                            <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                            <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                        </select>
                    </div>
                    <div class="col-md-2 d-grid">
                        <button type="submit" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Notices List --}}
    <div class="col-12">
        <div class="row g-4">
            @forelse($notices as $notice)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm hover-shadow transition">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <span class="badge bg-{{ $notice->priority === 'high' ? 'danger' : ($notice->priority === 'medium' ? 'warning' : 'info') }}">
                                {{ strtoupper($notice->priority) }}
                            </span>
                            <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> {{ $notice->created_at->format('d M, Y') }}</span>
                        </div>
                        <h5 class="fw-bold mb-3">
                            <a href="{{ route('resident.notices.show', $notice) }}" class="text-dark text-decoration-none">
                                {{ $notice->title }}
                            </a>
                        </h5>
                        <p class="text-muted small mb-4 line-clamp-3">
                            {{ Str::limit(strip_tags($notice->content), 120) }}
                        </p>
                        <div class="d-flex justify-content-between align-items-center mt-auto">
                            <div class="d-flex align-items-center gap-2">
                                <div class="bg-light rounded-circle p-2" style="width:32px;height:32px;display:flex;align-items:center;justify-content:center">
                                    <i class="bi bi-megaphone text-primary"></i>
                                </div>
                                <span class="small text-muted">{{ ucfirst($notice->type) }}</span>
                            </div>
                            <a href="{{ route('resident.notices.show', $notice) }}" class="btn btn-link btn-sm text-primary p-0 text-decoration-none fw-bold">
                                Read More <i class="bi bi-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5">
                <div class="mb-3"><i class="bi bi-megaphone display-1 text-muted opacity-25"></i></div>
                <h5 class="text-muted">No notices or announcements found.</h5>
            </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $notices->links() }}
        </div>
    </div>
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
.hover-shadow:hover {
    transform: translateY(-5px);
    box-shadow: 0 .5rem 1rem rgba(0,0,0,.15)!important;
}
.transition {
    transition: all .3s ease;
}
</style>
@endsection
