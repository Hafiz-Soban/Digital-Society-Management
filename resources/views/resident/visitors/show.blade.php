@extends('layouts.resident')
@section('title','Visitor Details')
@section('page-title','Visitor Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $visitor->visitor_name }}</h5>
        <p class="text-muted small mb-0">Visitor request details</p>
    </div>
    <div class="d-flex gap-2">
        @if(in_array($visitor->status, ['pending','approved']))
        <a href="{{ route('resident.visitors.edit', $visitor) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        @endif
        <a href="{{ route('resident.visitors.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="p-4 text-center"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6bb5);border-radius:12px 12px 0 0">
                    <div class="bg-white bg-opacity-20 rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:70px;height:70px">
                        <i class="bi bi-person-fill text-white fs-1"></i>
                    </div>
                    <h5 class="text-white fw-bold mb-1">{{ $visitor->visitor_name }}</h5>
                    <div>{!! $visitor->status_badge !!}</div>
                </div>
                <div class="p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-telephone me-2"></i>Phone</span>
                            <span class="fw-semibold small">{{ $visitor->visitor_phone ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-card-text me-2"></i>CNIC</span>
                            <span class="fw-semibold small">{{ $visitor->visitor_cnic ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-car-front me-2"></i>Vehicle</span>
                            <span class="fw-semibold small">{{ $visitor->vehicle_number ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-chat me-2"></i>Purpose</span>
                            <span class="fw-semibold small">{{ $visitor->purpose }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-clock me-2"></i>Expected</span>
                            <span class="fw-semibold small">{{ $visitor->expected_arrival?->format('d M Y H:i') ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-box-arrow-in-right me-2"></i>Arrived</span>
                            <span class="fw-semibold small">{{ $visitor->actual_arrival?->format('d M Y H:i') ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0 py-2">
                            <span class="text-muted small"><i class="bi bi-box-arrow-right me-2"></i>Departed</span>
                            <span class="fw-semibold small">{{ $visitor->departure_time?->format('d M Y H:i') ?? '—' }}</span>
                        </li>
                    </ul>
                </div>
                <div class="mt-4 text-center d-grid gap-2 px-4 pb-4">
                    <a href="{{ route('resident.visitors.print', $visitor) }}" target="_blank" class="btn btn-outline-dark">
                        <i class="bi bi-printer me-2"></i>Print Visitor Pass
                    </a>
                </div>
            </div>
        </div>

        @if(in_array($visitor->status, ['pending','approved']))
        <div class="card mt-3">
            <div class="card-body">
                <form method="POST" action="{{ route('resident.visitors.cancel', $visitor) }}"
                      onsubmit="return confirm('Are you sure you want to cancel this visitor request?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-x-circle me-2"></i>Cancel Visitor Request
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>

    <div class="col-md-7">
        {{-- Notes --}}
        @if($visitor->notes)
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-journal-text me-2 text-secondary"></i>Notes</h6>
            </div>
            <div class="card-body">
                <p class="mb-0 text-muted">{{ $visitor->notes }}</p>
            </div>
        </div>
        @endif

        {{-- Status Timeline --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i>Visit Timeline</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    <div class="timeline-item {{ $visitor->created_at ? 'success' : '' }}">
                        <div class="fw-semibold small">Request Created</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $visitor->created_at->format('d M Y H:i') }}</div>
                    </div>
                    <div class="timeline-item {{ in_array($visitor->status,['approved','checked_in','checked_out']) ? 'success' : ($visitor->status==='denied'?'danger':'') }}">
                        <div class="fw-semibold small">
                            @if($visitor->status === 'denied') Request Denied
                            @elseif(in_array($visitor->status,['approved','checked_in','checked_out'])) Request Approved
                            @else Awaiting Approval
                            @endif
                        </div>
                        <div class="text-muted" style="font-size:.75rem">
                            {{ $visitor->approvedBy ? 'By '.$visitor->approvedBy->name : 'Auto-approved by resident' }}
                        </div>
                    </div>
                    <div class="timeline-item {{ in_array($visitor->status,['checked_in','checked_out']) ? 'success' : '' }}">
                        <div class="fw-semibold small">Visitor Arrived</div>
                        <div class="text-muted" style="font-size:.75rem">
                            {{ $visitor->actual_arrival?->format('d M Y H:i') ?? 'Not yet arrived' }}
                        </div>
                    </div>
                    <div class="timeline-item {{ $visitor->status==='checked_out' ? 'success' : '' }}">
                        <div class="fw-semibold small">Visitor Departed</div>
                        <div class="text-muted" style="font-size:.75rem">
                            {{ $visitor->departure_time?->format('d M Y H:i') ?? 'Not yet departed' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Security Logs --}}
        @if($visitor->securityLogs->count())
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-shield-check me-2 text-success"></i>Security Log</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-sm mb-0">
                        <thead class="table-light">
                            <tr><th>Event</th><th>By</th><th>Time</th></tr>
                        </thead>
                        <tbody>
                            @foreach($visitor->securityLogs as $log)
                            <tr>
                                <td>{{ ucwords(str_replace('_',' ',$log->event_type)) }}</td>
                                <td>{{ $log->loggedBy->name ?? '—' }}</td>
                                <td class="text-muted small">{{ $log->created_at->format('d M H:i') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
