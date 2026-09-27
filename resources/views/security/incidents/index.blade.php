@extends('layouts.security')
@section('title', 'Security Incidents')
@section('page-title', 'Security Incidents')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('security.incidents.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Search</label>
                <input type="text" name="search" class="form-control" placeholder="Title, description, location..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Type</label>
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="theft" {{ request('type') == 'theft' ? 'selected' : '' }}>Theft</option>
                    <option value="property_damage" {{ request('type') == 'property_damage' ? 'selected' : '' }}>Property Damage</option>
                    <option value="unauthorized_access" {{ request('type') == 'unauthorized_access' ? 'selected' : '' }}>Unauthorized Access</option>
                    <option value="security_violation" {{ request('type') == 'security_violation' ? 'selected' : '' }}>Security Violation</option>
                    <option value="other" {{ request('type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="reported" {{ request('status') == 'reported' ? 'selected' : '' }}>Reported</option>
                    <option value="under_review" {{ request('status') == 'under_review' ? 'selected' : '' }}>Under Review</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                </select>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="row g-4">
    @forelse($incidents as $incident)
    <div class="col-md-6 col-lg-4">
        <div class="card h-100 shadow-sm border-0">
            @if($incident->image)
                <img src="{{ asset('storage/' . $incident->image) }}" class="card-img-top" style="height: 180px; object-fit: cover;">
            @else
                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 180px;">
                    <i class="bi bi-shield-exclamation display-4 text-muted opacity-25"></i>
                </div>
            @endif
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25">{{ $incident->type_label }}</span>
                    {!! $incident->status_badge !!}
                </div>
                <h6 class="fw-bold mb-2">{{ Str::limit($incident->title, 40) }}</h6>
                <p class="text-muted small mb-3">{{ Str::limit($incident->description, 80) }}</p>
                <div class="d-flex align-items-center gap-2 text-muted small mb-3">
                    <i class="bi bi-geo-alt"></i> {{ $incident->location }}
                </div>
                <div class="d-flex justify-content-between align-items-center mt-auto pt-2 border-top">
                    <small class="text-muted">{{ $incident->created_at->diffForHumans() }}</small>
                    <a href="{{ route('security.incidents.show', $incident) }}" class="btn btn-sm btn-outline-dark">View Details</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <div class="bg-light rounded-circle p-4 d-inline-block mb-3">
            <i class="bi bi-shield-check display-4 text-muted"></i>
        </div>
        <h5 class="text-muted">No security incidents reported.</h5>
        <a href="{{ route('security.incidents.create') }}" class="btn btn-danger mt-2">Report New Incident</a>
    </div>
    @endforelse
</div>

<div class="mt-4">
    {{ $incidents->links() }}
</div>
@endsection
