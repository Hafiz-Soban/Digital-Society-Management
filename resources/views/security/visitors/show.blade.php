@extends('layouts.security')
@section('title', 'Visitor Details')
@section('page-title', 'Visitor Details')

@section('content')
<div class="row g-4">
    <div class="col-md-5">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Visitor Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-light rounded-circle p-4 d-inline-block mb-3">
                        <i class="bi bi-person-badge fs-1 text-danger"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $visitor->visitor_name }}</h5>
                    <div class="mb-3">{!! $visitor->status_badge !!}</div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">CNIC Number</span>
                        <span class="fw-bold small">{{ $visitor->visitor_cnic ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Phone Number</span>
                        <span class="fw-bold small">{{ $visitor->visitor_phone ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Vehicle Number</span>
                        <span class="fw-bold small">{{ $visitor->vehicle_number ?? 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Purpose</span>
                        <span class="fw-bold small">{{ $visitor->purpose }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Entry Time</span>
                        <span class="fw-bold small text-success">{{ $visitor->actual_arrival ? $visitor->actual_arrival->format('d M Y, H:i') : 'N/A' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Exit Time</span>
                        <span class="fw-bold small text-danger">{{ $visitor->departure_time ? $visitor->departure_time->format('d M Y, H:i') : 'N/A' }}</span>
                    </li>
                </ul>

                @if($visitor->status == 'checked_in')
                    <div class="mt-4">
                        <form action="{{ route('security.visitors.checkout', $visitor) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-warning w-100 fw-bold">
                                <i class="bi bi-box-arrow-right me-2"></i>RECORD EXIT / CHECK-OUT
                            </button>
                        </form>
                    </div>
                @endif

                <div class="mt-3 text-center">
                    <button onclick="window.print()" class="btn btn-sm btn-outline-secondary px-3">
                        <i class="bi bi-printer me-2"></i>Print Visitor Pass
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-primary">Resident Details</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 mb-4">
                    <img src="{{ $visitor->resident->user->avatar_url }}" class="rounded-circle border" width="60" height="60" style="object-fit: cover;">
                    <div>
                        <h6 class="fw-bold mb-0">{{ $visitor->resident->user->name }}</h6>
                        <small class="text-muted">Resident ID: {{ $visitor->resident->resident_id }}</small>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">House Number</small>
                            <span class="fw-bold">{{ $visitor->resident->house->house_number ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-3 bg-light rounded-3">
                            <small class="text-muted d-block">Block / Floor</small>
                            <span class="fw-bold">{{ $visitor->resident->house->block ?? 'N/A' }} / {{ $visitor->resident->house->floor ?? 'N/A' }}</span>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center">
                            <div>
                                <small class="text-muted d-block">Contact Number</small>
                                <span class="fw-bold">{{ $visitor->resident->user->phone ?? 'N/A' }}</span>
                            </div>
                            @if($visitor->resident->user->phone)
                                <a href="tel:{{ $visitor->resident->user->phone }}" class="btn btn-sm btn-primary rounded-pill">
                                    <i class="bi bi-telephone-fill me-1"></i> Call
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark">Security Timeline & Logs</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @forelse($visitor->securityLogs as $log)
                        <div class="list-group-item px-0">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="badge bg-light text-dark border small">{{ $log->event_type }}</span>
                                <small class="text-muted">{{ $log->created_at->format('d M, H:i') }}</small>
                            </div>
                            <p class="mb-1 small">{{ $log->description }}</p>
                            <small class="text-muted">Recorded by: {{ $log->loggedBy->name }}</small>
                        </div>
                    @empty
                        <div class="text-center py-3 text-muted">No logs recorded for this visitor</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .sidebar, .topbar { display: none !important; }
    .main-content { margin-left: 0 !important; }
    .card { border: 1px solid #ddd !important; box-shadow: none !important; }
}
</style>
@endsection
