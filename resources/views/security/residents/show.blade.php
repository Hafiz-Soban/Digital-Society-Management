@extends('layouts.security')
@section('title', 'Verify Resident')
@section('page-title', 'Resident Verification Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h5 class="fw-bold mb-0 text-danger"><i class="bi bi-shield-check me-2"></i>VERIFICATION PROFILE</h5>
                    <a href="{{ route('security.residents.index') }}" class="btn btn-sm btn-outline-secondary">
                        <i class="bi bi-arrow-left me-1"></i> Back to List
                    </a>
                </div>

                <div class="row g-4 align-items-center">
                    <div class="col-md-3 text-center border-end">
                        <img src="{{ $resident->user->avatar_url }}" class="rounded-circle border p-1 mb-3" width="150" height="150" style="object-fit: cover;">
                        <h5 class="fw-bold mb-1">{{ $resident->user->name }}</h5>
                        <div class="mb-2">{!! $resident->status_badge !!}</div>
                        <span class="badge bg-light text-dark border">{{ $resident->resident_id }}</span>
                    </div>
                    <div class="col-md-9">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold d-block text-uppercase">House Information</label>
                                <div class="fs-5 fw-bold text-dark">House # {{ $resident->house->house_number ?? 'N/A' }}</div>
                                <div class="text-muted">Block {{ $resident->house->block ?? 'N/A' }}, Floor {{ $resident->house->floor ?? 'N/A' }}</div>
<<<<<<< HEAD
                                <div class="text-muted small">{{ $resident->house->floor ?? 'N/A' }} • {{ $resident->house->bedrooms ?? '0' }} Bedrooms</div>
=======
                                <div class="text-muted small">{{ ucfirst($resident->house->type ?? 'N/A') }} • {{ $resident->house->bedrooms ?? '0' }} Bedrooms</div>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold d-block text-uppercase">Contact Details</label>
                                <div class="fs-5 fw-bold text-dark">{{ $resident->user->phone ?? 'N/A' }}</div>
                                <div class="text-muted">{{ $resident->user->email }}</div>
                                <div class="mt-2">
                                    @if($resident->user->phone)
                                        <a href="tel:{{ $resident->user->phone }}" class="btn btn-sm btn-primary rounded-pill px-3 me-2">
                                            <i class="bi bi-telephone-fill me-1"></i> Call
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold d-block text-uppercase">Personal Details</label>
                                <div class="text-dark"><strong>CNIC:</strong> {{ $resident->cnic ?? 'N/A' }}</div>
                                <div class="text-dark"><strong>Gender:</strong> {{ ucfirst($resident->gender ?? 'N/A') }}</div>
                                <div class="text-dark"><strong>Ownership:</strong> {{ ucfirst($resident->ownership_type ?? 'N/A') }}</div>
                            </div>
                            <div class="col-md-6">
                                <label class="text-muted small fw-bold d-block text-uppercase">Emergency Contact</label>
                                <div class="text-dark fw-bold">{{ $resident->emergency_contact_name ?? 'N/A' }}</div>
                                <div class="text-muted small">{{ $resident->emergency_contact_relation ?? 'N/A' }}</div>
                                <div class="text-primary fw-bold">{{ $resident->emergency_contact_phone ?? 'N/A' }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-dark">RECENT VISITORS FOR THIS HOUSE</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Visitor Name</th>
                                <th>Purpose</th>
                                <th>Arrival Time</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($resident->visitors as $visitor)
                            <tr>
                                <td class="ps-4">
                                    <div class="fw-bold">{{ $visitor->visitor_name }}</div>
                                    <small class="text-muted">{{ $visitor->visitor_phone }}</small>
                                </td>
                                <td>{{ $visitor->purpose }}</td>
                                <td>{{ $visitor->actual_arrival ? $visitor->actual_arrival->format('d M Y, H:i') : 'Pending' }}</td>
                                <td>{!! $visitor->status_badge !!}</td>
                                <td class="text-end pe-4">
                                    <a href="{{ route('security.visitors.show', $visitor) }}" class="btn btn-sm btn-light">View</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No visitor history found for this resident.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
