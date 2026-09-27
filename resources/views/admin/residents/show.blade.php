@extends('layouts.admin')
@section('title', 'Resident Details')
@section('page-title', 'Resident Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $resident->user->name }}</h5>
        <p class="text-muted small mb-0">Resident ID: <code>{{ $resident->resident_id }}</code></p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.residents.edit', $resident) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Profile Card -->
    <div class="col-md-4">
        <div class="card text-center p-4">
            <img src="{{ $resident->user->avatar_url }}" class="rounded-circle mx-auto mb-3" width="80" height="80" alt="">
            <h5 class="fw-bold">{{ $resident->user->name }}</h5>
            <p class="text-muted small">{{ $resident->user->email }}</p>
            <div class="mb-2">{!! $resident->status_badge !!}</div>
            <div class="mb-3">
                <span class="badge {{ $resident->ownership_type == 'owner' ? 'bg-primary' : 'bg-info' }}">
                    {{ ucfirst($resident->ownership_type) }}
                </span>
            </div>
            <div class="border-top pt-3">
                <div class="row text-center">
                    <div class="col-4">
                        <div class="fw-bold text-primary">{{ $resident->complaints->count() }}</div>
                        <div class="text-muted" style="font-size:0.75rem">Complaints</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-warning">{{ $resident->maintenanceRequests->count() }}</div>
                        <div class="text-muted" style="font-size:0.75rem">Maintenance</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-info">{{ $resident->visitors->count() }}</div>
                        <div class="text-muted" style="font-size:0.75rem">Visitors</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- House Info -->
        @if($resident->house)
        <div class="card mt-3 p-3">
            <h6 class="fw-semibold mb-3"><i class="bi bi-house me-2 text-primary"></i>House Details</h6>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">House No.</span>
                <span class="fw-semibold">{{ $resident->house->house_number }}</span>
            </div>
            <div class="d-flex justify-content-between mb-2">
<<<<<<< HEAD
                <span class="text-muted small">Floor</span>
                <span>{{ $resident->house->floor ?? '-' }}</span>
=======
                <span class="text-muted small">Type</span>
                <span>{{ ucfirst($resident->house->type) }}</span>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span class="text-muted small">Bedrooms</span>
                <span>{{ $resident->house->bedrooms }}</span>
            </div>
            <div class="d-flex justify-content-between">
                <span class="text-muted small">Maintenance Fee</span>
                <span class="fw-semibold">PKR {{ number_format($resident->house->monthly_maintenance) }}</span>
            </div>
        </div>
        @endif
    </div>

    <!-- Details -->
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="text-muted small">Phone</label>
                        <div class="fw-semibold">{{ $resident->user->phone ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">CNIC</label>
                        <div class="fw-semibold">{{ $resident->cnic ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Date of Birth</label>
                        <div class="fw-semibold">{{ $resident->date_of_birth?->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Gender</label>
                        <div class="fw-semibold">{{ ucfirst($resident->gender ?? '-') }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Move In Date</label>
                        <div class="fw-semibold">{{ $resident->move_in_date?->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="col-md-6">
                        <label class="text-muted small">Family Members</label>
                        <div class="fw-semibold">{{ $resident->family_members }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="card mb-3">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-telephone-fill me-2 text-danger"></i>Emergency Contact</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="text-muted small">Name</label>
                        <div class="fw-semibold">{{ $resident->emergency_contact_name ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small">Phone</label>
                        <div class="fw-semibold">{{ $resident->emergency_contact_phone ?? '-' }}</div>
                    </div>
                    <div class="col-md-4">
                        <label class="text-muted small">Relation</label>
                        <div class="fw-semibold">{{ $resident->emergency_contact_relation ?? '-' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="card mb-3">
            <div class="card-header bg-white py-3 d-flex justify-content-between">
                <h6 class="mb-0 fw-semibold">Recent Complaints</h6>
                <a href="{{ route('admin.complaints.index') }}?resident={{ $resident->id }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr><th>Number</th><th>Title</th><th>Priority</th><th>Status</th></tr>
                    </thead>
                    <tbody>
                        @forelse($resident->complaints as $complaint)
                        <tr>
                            <td><code>{{ $complaint->complaint_number }}</code></td>
                            <td>{{ Str::limit($complaint->title, 30) }}</td>
                            <td>{!! $complaint->priority_badge !!}</td>
                            <td>{!! $complaint->status_badge !!}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center text-muted py-2">No complaints</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
