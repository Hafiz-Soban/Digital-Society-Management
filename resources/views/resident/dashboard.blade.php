@extends('layouts.resident')
@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')
<<<<<<< HEAD
=======
{{-- Restriction Warning --}}
@if($resident->isRestricted())
<div class="card mb-4 border-0 shadow-sm" style="background: #fff5f5; border-left: 5px solid #dc3545 !important;">
    <div class="card-body p-4">
        <div class="d-flex gap-3">
            <div class="rounded-circle bg-danger bg-opacity-10 p-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                <i class="bi bi-exclamation-octagon-fill text-danger fs-2"></i>
            </div>
            <div>
                <h5 class="text-danger fw-bold mb-1">Account Restricted</h5>
                <p class="text-dark mb-3">Your account has been restricted due to outstanding maintenance dues of <strong>Rs. {{ number_format($resident->due_amount) }}</strong>. Only emergency features are currently enabled.</p>
                <div class="d-flex gap-2">
                    <a href="{{ route('resident.emergency.index') }}" class="btn btn-danger btn-sm px-4">
                        <i class="bi bi-exclamation-triangle me-2"></i>Emergency Center
                    </a>
                    <button class="btn btn-outline-danger btn-sm px-4" onclick="alert('Please contact society office for payment.')">
                        <i class="bi bi-credit-card me-2"></i>Pay Dues
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
{{-- Welcome Banner --}}
<div class="card mb-4" style="background:linear-gradient(135deg,#0f4c81,#1a6bb5);border-radius:14px">
    <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div>
            <h4 class="text-white fw-bold mb-1">Welcome back, {{ auth()->user()->name }}! 👋</h4>
            <div class="d-flex flex-wrap gap-2 text-white-50 small">
                <span><i class="bi bi-person-badge me-1"></i>ID: {{ $resident->resident_id }}</span>
<<<<<<< HEAD
                <span class="d-none d-sm-inline">·</span>
                <span><i class="bi bi-house me-1"></i>{{ $resident->house ? 'House '.$resident->house->house_number.', Block '.$resident->house->block : 'No house assigned' }}</span>
=======
                @if(!$resident->isRestricted())
                <span class="d-none d-sm-inline">·</span>
                <span><i class="bi bi-house me-1"></i>{{ $resident->house ? 'House '.$resident->house->house_number.', Block '.$resident->house->block : 'No house assigned' }}</span>
                @endif
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                <span class="d-none d-sm-inline">·</span>
                <span><i class="bi bi-shield-check me-1"></i>{{ ucfirst($resident->ownership_type) }}</span>
                <span class="d-none d-sm-inline">·</span>
                <span><i class="bi bi-calendar3 me-1"></i>{{ now()->format('l, d M Y') }}</span>
            </div>
        </div>
        <img src="{{ auth()->user()->avatar_url }}" class="rounded-circle border border-white border-3"
             width="64" height="64" alt="Avatar" style="object-fit:cover">
    </div>
</div>

{{-- Active Emergency Alerts --}}
@if($activeAlerts->count())
<div class="alert alert-danger d-flex gap-3 align-items-start mb-4 border border-danger">
    <i class="bi bi-exclamation-triangle-fill fs-4 flex-shrink-0 mt-1"></i>
    <div>
        <strong>⚠ Active Emergency Alert{{ $activeAlerts->count() > 1 ? 's' : '' }}</strong>
        @foreach($activeAlerts as $alert)
            <div class="mt-1" style="font-size:.85rem">
                <span class="badge bg-danger me-1">{{ strtoupper($alert->type) }}</span>
                {{ $alert->title }} — <span class="text-muted">{{ $alert->created_at->diffForHumans() }}</span>
            </div>
        @endforeach
        <a href="{{ route('resident.emergency.index') }}" class="btn btn-sm btn-danger mt-2">View Details</a>
    </div>
</div>
@endif

<<<<<<< HEAD
=======
@if(!$resident->isRestricted())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="stat-card bg-primary text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['total_complaints'] }}</div>
                    <div class="stat-label">Total Complaints</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-chat-square-text text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:.72rem;opacity:.8">
                {{ $stats['open_complaints'] }} open · {{ $stats['resolved_complaints'] }} resolved
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-warning text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['pending_maintenance'] }}</div>
                    <div class="stat-label">Pending Maintenance</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-tools text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:.72rem;opacity:.8">Active requests</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-info text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['total_visitors'] }}</div>
                    <div class="stat-label">Total Visitors</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-person-badge text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:.72rem;opacity:.8">{{ $stats['pending_visitors'] }} pending</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="stat-card bg-success text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['unread_notifications'] }}</div>
                    <div class="stat-label">Notifications</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-bell text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:.72rem;opacity:.8">Unread alerts</div>
        </div>
    </div>
</div>
<<<<<<< HEAD
=======
@endif
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

<div class="row g-4">
    {{-- Left Column --}}
    <div class="col-lg-8">
<<<<<<< HEAD

=======
        @if(!$resident->isRestricted())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        {{-- Recent Complaints --}}
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-chat-square-text me-2 text-primary"></i>Recent Complaints</h6>
                <a href="{{ route('resident.complaints.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Number</th><th>Title</th><th>Priority</th><th>Status</th><th>Date</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentComplaints as $c)
                            <tr>
                                <td><a href="{{ route('resident.complaints.show',$c) }}" class="text-decoration-none fw-semibold text-primary">{{ $c->complaint_number }}</a></td>
                                <td>{{ Str::limit($c->title,35) }}</td>
                                <td>{!! $c->priority_badge !!}</td>
                                <td>{!! $c->status_badge !!}</td>
                                <td class="text-muted small">{{ $c->created_at->format('d M') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-chat-square d-block fs-3 mb-1"></i>No complaints yet
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<<<<<<< HEAD

=======
        @endif

        {{-- Emergency SOS Panel (Visible even if restricted) --}}
        <div class="card mb-4 border-danger">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Emergency SOS Center</h6>
            </div>
            <div class="card-body text-center py-4">
                <p class="text-muted mb-4">Click the button below to send an immediate alert to security and management.</p>
                <div class="row g-3 justify-content-center">
                    <div class="col-md-5">
                        <form action="{{ route('resident.emergency.sos') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="fire">
                            <button type="submit" class="btn btn-outline-danger w-100 py-3 fw-bold">
                                <i class="bi bi-fire fs-3 d-block mb-1"></i> FIRE ALERT
                            </button>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <form action="{{ route('resident.emergency.sos') }}" method="POST">
                            @csrf
                            <input type="hidden" name="type" value="medical">
                            <button type="submit" class="btn btn-danger w-100 py-3 fw-bold shadow">
                                <i class="bi bi-heart-pulse fs-3 d-block mb-1"></i> MEDICAL EMERGENCY
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        @if(!$resident->isRestricted())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        {{-- Active Maintenance --}}
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-tools me-2 text-warning"></i>Active Maintenance Requests</h6>
                <a href="{{ route('resident.maintenance.index') }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Number</th><th>Title</th><th>Category</th><th>Status</th><th>Staff</th></tr>
                        </thead>
                        <tbody>
                            @forelse($activeMaintenance as $m)
                            <tr>
                                <td><a href="{{ route('resident.maintenance.show',$m) }}" class="text-decoration-none fw-semibold text-warning">{{ $m->request_number }}</a></td>
                                <td>{{ Str::limit($m->title,30) }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($m->category) }}</span></td>
                                <td>{!! $m->status_badge !!}</td>
                                <td class="text-muted small">{{ $m->assignedStaff?->name ?? '—' }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center text-muted py-4">
                                <i class="bi bi-tools d-block fs-3 mb-1"></i>No active requests
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
<<<<<<< HEAD

        {{-- Recent Visitors --}}
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-badge me-2 text-info"></i>Recent Visitors</h6>
                <a href="{{ route('resident.visitors.index') }}" class="btn btn-sm btn-outline-info">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Name</th><th>Purpose</th><th>Expected</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisitors as $v)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $v->visitor_name }}</div>
                                    <div class="text-muted small">{{ $v->visitor_phone }}</div>
                                </td>
                                <td>{{ Str::limit($v->purpose,25) }}</td>
                                <td class="text-muted small">{{ $v->expected_arrival?->format('d M H:i') ?? '—' }}</td>
                                <td>{!! $v->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">
                                <i class="bi bi-person-badge d-block fs-3 mb-1"></i>No visitors yet
                            </td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
=======
        @endif
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    </div>

    {{-- Right Column --}}
    <div class="col-lg-4">
<<<<<<< HEAD

        {{-- House Info Card --}}
        @if($resident->house)
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-house-door me-2 text-primary"></i>My House</h6>
=======
        {{-- House Info Card (Restricted visibility) --}}
        @if($resident->house)
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-house-door me-2 text-primary"></i>Account & House</h6>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            </div>
            <div class="card-body">
                <div class="text-center mb-3">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-2"
                         style="width:60px;height:60px">
                        <i class="bi bi-house-fill text-primary fs-2"></i>
                    </div>
                    <h5 class="fw-bold mb-0">{{ $resident->house->house_number }}</h5>
<<<<<<< HEAD
                    <small class="text-muted">{{ $resident->house->floor ?? '' }}</small>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Block</span>
                        <span class="fw-semibold small">{{ $resident->house->block ?? '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Floor</span>
                        <span class="fw-semibold small">{{ $resident->house->floor ?? '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Bedrooms</span>
                        <span class="fw-semibold small">{{ $resident->house->bedrooms }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Maintenance</span>
                        <span class="fw-semibold small text-primary">PKR {{ number_format($resident->house->monthly_maintenance) }}</span>
                    </li>
                </ul>
                <a href="{{ route('resident.house.index') }}" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    View Full Details
                </a>
=======
                    <small class="text-muted">{{ ucfirst($resident->house->type) }}</small>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Outstanding Dues</span>
                        <span class="fw-bold small {{ $resident->due_amount > 10000 ? 'text-danger' : 'text-success' }}">Rs. {{ number_format($resident->due_amount) }}</span>
                    </li>
                    @if(!$resident->isRestricted())
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Monthly Maintenance</span>
                        <span class="fw-semibold small text-primary">Rs. {{ number_format($resident->house->monthly_maintenance) }}</span>
                    </li>
                    @endif
                </ul>
                @if(!$resident->isRestricted())
                <a href="{{ route('resident.house.index') }}" class="btn btn-sm btn-outline-primary w-100 mt-3">
                    View House Details
                </a>
                @endif
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            </div>
        </div>
        @endif

<<<<<<< HEAD
        {{-- Latest Notices --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-megaphone me-2 text-success"></i>Latest Notices</h6>
=======
        @if(!$resident->isRestricted())
        {{-- Latest Notices --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-megaphone me-2 text-success"></i>Latest Announcements</h6>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            </div>
            <div class="card-body p-0">
                @forelse($notices as $notice)
                <a href="{{ route('resident.notices.show',$notice) }}"
                   class="d-flex gap-3 p-3 text-decoration-none {{ !$loop->last ? 'border-bottom' : '' }} hover-bg">
                    <div class="flex-shrink-0 mt-1">
                        <div class="rounded-2 d-flex align-items-center justify-content-center"
                             style="width:32px;height:32px;background:{{ $notice->priority==='urgent'?'#fee2e2':'#dbeafe' }}">
                            <i class="bi bi-megaphone" style="color:{{ $notice->priority==='urgent'?'#dc2626':'#2563eb' }};font-size:.8rem"></i>
                        </div>
                    </div>
                    <div>
                        <div class="fw-semibold text-dark" style="font-size:.82rem">{{ Str::limit($notice->title,40) }}</div>
                        <div class="text-muted" style="font-size:.72rem">{{ $notice->created_at->diffForHumans() }}</div>
                    </div>
                </a>
                @empty
                <div class="text-center text-muted py-4" style="font-size:.82rem">
<<<<<<< HEAD
                    <i class="bi bi-megaphone d-block fs-3 mb-1"></i>No notices
                </div>
                @endforelse
            </div>
            @if($notices->count())
            <div class="card-footer bg-white text-center py-2">
                <a href="{{ route('resident.notices.index') }}" class="text-primary" style="font-size:.78rem">View all notices</a>
            </div>
            @endif
        </div>
=======
                    <i class="bi bi-megaphone d-block fs-3 mb-1"></i>No announcements
                </div>
                @endforelse
            </div>
        </div>
        @endif
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

        {{-- Quick Actions --}}
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-lightning me-2 text-warning"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
<<<<<<< HEAD
=======
                    @if(!$resident->isRestricted())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    <a href="{{ route('resident.visitors.create') }}" class="btn btn-outline-info btn-sm text-start">
                        <i class="bi bi-person-plus me-2"></i>Add Visitor
                    </a>
                    <a href="{{ route('resident.complaints.create') }}" class="btn btn-outline-danger btn-sm text-start">
                        <i class="bi bi-chat-square-plus me-2"></i>Submit Complaint
                    </a>
                    <a href="{{ route('resident.maintenance.create') }}" class="btn btn-outline-warning btn-sm text-start">
                        <i class="bi bi-tools me-2"></i>Request Maintenance
                    </a>
<<<<<<< HEAD
                    <a href="{{ route('resident.emergency.index') }}" class="btn btn-danger btn-sm text-start">
=======
                    @endif
                    <a href="{{ route('resident.emergency.index') }}" class="btn btn-danger btn-sm text-start shadow-sm">
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <i class="bi bi-exclamation-triangle me-2"></i>Emergency / SOS
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
