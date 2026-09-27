@extends('layouts.resident')
@section('title', 'Society Directory')
@section('page-title', 'Society Directory')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Society Directory</h5>
    <p class="text-muted small mb-0">Contact information for management and emergency services</p>
</div>

<div class="row g-4">
    {{-- Emergency Contacts --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm overflow-hidden">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-exclamation-triangle-fill me-2"></i>Emergency & Utility Services</h6>
            </div>
            <div class="card-body p-0">
                <div class="row g-0">
                    @foreach($emergencyContacts as $contact)
                    <div class="col-md-4 border-end border-bottom">
                        <div class="p-4 d-flex align-items-center justify-content-between">
                            <div>
                                <div class="fw-bold text-dark">{{ $contact['name'] }}</div>
                                <div class="text-muted small">{{ $contact['type'] }}</div>
                            </div>
                            <a href="tel:{{ $contact['phone'] }}" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                                <i class="bi bi-telephone-fill me-1"></i> {{ $contact['phone'] }}
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Management Staff --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-primary"><i class="bi bi-person-workspace me-2"></i>Society Management</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($admins as $admin)
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $admin->avatar_url }}" class="rounded-circle" width="45" height="45" style="object-fit:cover">
                            <div class="flex-grow-1">
                                <div class="fw-bold mb-0">{{ $admin->name }}</div>
                                <div class="text-muted small">Administrator</div>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="mailto:{{ $admin->email }}" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-envelope text-primary"></i></a>
                                @if($admin->phone)
                                <a href="tel:{{ $admin->phone }}" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-telephone text-primary"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">No management staff found</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Security Team --}}
    <div class="col-md-6">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark"><i class="bi bi-shield-lock-fill me-2"></i>Security Team</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($securityGuards as $guard)
                    <div class="list-group-item p-3">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $guard->avatar_url }}" class="rounded-circle" width="45" height="45" style="object-fit:cover">
                            <div class="flex-grow-1">
                                <div class="fw-bold mb-0">{{ $guard->name }}</div>
                                <div class="text-muted small">Security Guard</div>
                            </div>
                            <div class="d-flex gap-2">
                                @if($guard->phone)
                                <a href="tel:{{ $guard->phone }}" class="btn btn-light btn-sm rounded-circle"><i class="bi bi-telephone text-dark"></i></a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">No security staff found</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Maintenance Staff --}}
    <div class="col-12">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-warning"><i class="bi bi-tools me-2"></i>Maintenance Staff</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Staff Name</th>
                                <th>Specialty</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Contact</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenanceStaff as $staff)
                            <tr>
                                <td class="ps-4">
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="bg-light rounded-circle p-2"><i class="bi bi-person text-secondary"></i></div>
                                        <div class="fw-bold">{{ $staff->name }}</div>
                                    </div>
                                </td>
                                <td><span class="badge bg-secondary opacity-75">{{ ucfirst($staff->specialty) }}</span></td>
                                <td>
                                    @if($staff->status === 'on_duty')
                                        <span class="badge bg-success">On Duty</span>
                                    @else
                                        <span class="badge bg-warning">Away</span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <a href="tel:{{ $staff->phone }}" class="btn btn-sm btn-outline-primary rounded-pill px-3">
                                        <i class="bi bi-telephone me-1"></i> {{ $staff->phone }}
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No maintenance staff available</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
