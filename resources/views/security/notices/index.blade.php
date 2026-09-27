@extends('layouts.security')
@section('title', 'Notices')
@section('page-title', 'Society Notices & Announcements')

@section('content')
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body">
        <form action="{{ route('security.notices.index') }}" method="GET" class="row g-3">
            <div class="col-md-9">
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search notices by title or content..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary w-100">Search</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($notices as $notice)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0 position-relative">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-{{ $notice->priority === 'high' || $notice->priority === 'urgent' ? 'danger' : 'info' }} mb-2">
                        {{ strtoupper($notice->priority) }}
                    </span>
                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> {{ $notice->created_at->format('d M, Y') }}</small>
                </div>
                <h6 class="fw-bold mb-3 text-dark">{{ $notice->title }}</h6>
                <p class="text-muted small mb-4 line-clamp-3">{{ Str::limit(strip_tags($notice->content), 120) }}</p>
                
                <div class="d-flex justify-content-between align-items-center mt-auto">
                    <span class="badge bg-light text-dark border small">{{ ucfirst($notice->type) }}</span>
                    <a href="{{ route('security.notices.show', $notice) }}" class="btn btn-link btn-sm text-primary text-decoration-none fw-bold p-0">
                        Read More <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="bg-light rounded-circle p-4 d-inline-block mb-3">
            <i class="bi bi-megaphone display-4 text-muted opacity-25"></i>
        </div>
        <h5 class="text-muted">No notices or announcements found.</h5>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $notices->links() }}
</div>

<style>
.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endsection
