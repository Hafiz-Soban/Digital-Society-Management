@extends('layouts.resident')
@section('title','Maintenance Request Details')
@section('page-title','Maintenance Request Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $maintenance->request_number }}</h5>
        <p class="text-muted small mb-0">{{ $maintenance->title }}</p>
    </div>
    <div class="d-flex gap-2">
        @if($maintenance->status === 'pending')
        <a href="{{ route('resident.maintenance.edit', $maintenance) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        @endif
        <a href="{{ route('resident.maintenance.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Left: Main Details --}}
    <div class="col-lg-8">

        {{-- Request Info --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-tools me-2 text-warning"></i>Request Details
                </h6>
                <div class="d-flex gap-2">
                    {!! $maintenance->priority_badge !!}
                    {!! $maintenance->status_badge !!}
                </div>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-3">{{ $maintenance->title }}</h5>

                <div class="row g-3 mb-4">
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Category</div>
                            <div class="fw-semibold">{{ ucfirst($maintenance->category) }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">House</div>
                            <div class="fw-semibold">{{ $maintenance->house->house_number ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Submitted</div>
                            <div class="fw-semibold">{{ $maintenance->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Scheduled</div>
                            <div class="fw-semibold">{{ $maintenance->scheduled_date?->format('d M Y') ?? 'TBD' }}</div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-semibold text-muted small text-uppercase mb-2">Description</h6>
                <p class="mb-4">{{ $maintenance->description }}</p>

                @if($maintenance->attachment)
                <div class="border rounded-3 p-3 d-flex align-items-center gap-3 mb-4">
                    <i class="bi bi-paperclip fs-4 text-warning"></i>
                    <div>
                        <div class="fw-semibold small">Attachment</div>
                        <a href="{{ asset('storage/'.$maintenance->attachment) }}" target="_blank"
                           class="text-primary small">View / Download</a>
                    </div>
                </div>
                @endif

                @if($maintenance->completion_notes)
                <div class="alert alert-success mb-0">
                    <h6 class="fw-semibold mb-1">
                        <i class="bi bi-check-circle me-2"></i>Completion Notes
                    </h6>
                    <p class="mb-1">{{ $maintenance->completion_notes }}</p>
                    @if($maintenance->completed_at)
                    <small class="text-muted">Completed on {{ $maintenance->completed_at->format('d M Y H:i') }}</small>
                    @endif
                    @if($maintenance->cost)
                    <div class="mt-1">
                        <span class="badge bg-success">Cost: PKR {{ number_format($maintenance->cost, 2) }}</span>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Status Timeline --}}
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-clock-history me-2 text-primary"></i>Progress Timeline
                </h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($maintenance->logs as $log)
                    <div class="timeline-item {{ $log->status === 'completed' ? 'success' : ($log->status === 'cancelled' ? 'danger' : 'info') }}">
                        <div class="fw-semibold small">{{ ucfirst(str_replace('_', ' ', $log->status)) }}</div>
                        <div class="text-muted small mb-1">{{ $log->comment }}</div>
                        <div class="text-muted" style="font-size:.7rem">
                            <i class="bi bi-person me-1"></i> {{ $log->user->name ?? 'System' }} • 
                            <i class="bi bi-clock me-1"></i> {{ $log->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @empty
                    <div class="timeline-item">
                        <div class="fw-semibold small">Request Submitted</div>
                        <div class="text-muted" style="font-size:.75rem">
                            {{ $maintenance->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Sidebar --}}
    <div class="col-lg-4">

        {{-- Assigned Staff --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-person-gear me-2 text-info"></i>Assigned Staff
                </h6>
            </div>
            <div class="card-body">
                @if($maintenance->assignedStaff)
                <div class="d-flex align-items-center gap-3">
                    <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:50px;height:50px">
                        <i class="bi bi-person-fill text-info fs-4"></i>
                    </div>
                    <div>
                        <div class="fw-bold">{{ $maintenance->assignedStaff->name }}</div>
                        <div class="text-muted small">{{ ucfirst($maintenance->assignedStaff->specialization) }}</div>
                        <div class="text-muted small">
                            <i class="bi bi-telephone me-1"></i>{{ $maintenance->assignedStaff->phone ?? '—' }}
                        </div>
                        <div class="mt-1">{!! $maintenance->assignedStaff->status_badge !!}</div>
                    </div>
                </div>
                @else
                <div class="text-center py-3 text-muted">
                    <i class="bi bi-person-x d-block fs-2 mb-2"></i>
                    <small>No staff assigned yet.<br>We'll notify you when assigned.</small>
                </div>
                @endif
            </div>
        </div>

        {{-- Quick Info --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">Quick Info</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Status</span>
                        {!! $maintenance->status_badge !!}
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Priority</span>
                        {!! $maintenance->priority_badge !!}
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Category</span>
                        <span class="fw-semibold small">{{ ucfirst($maintenance->category) }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">House</span>
                        <span class="fw-semibold small">{{ $maintenance->house->house_number ?? '—' }}</span>
                    </li>
                    @if($maintenance->cost)
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Cost</span>
                        <span class="fw-bold text-success small">PKR {{ number_format($maintenance->cost, 2) }}</span>
                    </li>
                    @endif
                </ul>
            </div>
        </div>

        {{-- Actions --}}
        @if($maintenance->status === 'pending')
        <div class="card">
            <div class="card-body d-grid gap-2">
                <a href="{{ route('resident.maintenance.edit', $maintenance) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-2"></i>Edit Request
                </a>
                <form method="POST" action="{{ route('resident.maintenance.cancel', $maintenance) }}"
                      onsubmit="return confirm('Cancel this maintenance request?')">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-x-circle me-2"></i>Cancel Request
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
