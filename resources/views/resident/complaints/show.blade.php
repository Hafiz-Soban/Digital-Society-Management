@extends('layouts.resident')
@section('title','Complaint Details')
@section('page-title','Complaint Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $complaint->complaint_number }}</h5>
        <p class="text-muted small mb-0">{{ $complaint->title }}</p>
    </div>
    <div class="d-flex gap-2">
        @if($complaint->status === 'pending')
        <a href="{{ route('resident.complaints.edit', $complaint) }}" class="btn btn-outline-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        @endif
        <a href="{{ route('resident.complaints.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    {{-- Left: Details --}}
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-chat-square-text me-2 text-primary"></i>Complaint Details</h6>
                <div class="d-flex gap-2">
                    {!! $complaint->priority_badge !!}
                    {!! $complaint->status_badge !!}
                </div>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-3">{{ $complaint->title }}</h5>
                <div class="row g-3 mb-4">
                    <div class="col-sm-4">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Category</div>
                            <div class="fw-semibold">{{ $complaint->category->name ?? '—' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Submitted</div>
                            <div class="fw-semibold">{{ $complaint->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Assigned To</div>
                            <div class="fw-semibold">{{ $complaint->assignedTo->name ?? 'Unassigned' }}</div>
                        </div>
                    </div>
                </div>

                <h6 class="fw-semibold text-muted small text-uppercase mb-2">Description</h6>
                <p class="mb-4">{{ $complaint->description }}</p>

                @if($complaint->attachment)
                <div class="border rounded-3 p-3 d-flex align-items-center gap-3">
                    <i class="bi bi-paperclip fs-4 text-primary"></i>
                    <div>
                        <div class="fw-semibold small">Attachment</div>
                        <a href="{{ asset('storage/'.$complaint->attachment) }}" target="_blank"
                           class="text-primary small">View / Download</a>
                    </div>
                </div>
                @endif

                @if($complaint->resolution_notes)
                <div class="alert alert-success mt-4 mb-0">
                    <h6 class="fw-semibold mb-1"><i class="bi bi-check-circle me-2"></i>Resolution Notes</h6>
                    <p class="mb-1">{{ $complaint->resolution_notes }}</p>
                    @if($complaint->resolved_at)
                    <small class="text-muted">Resolved on {{ $complaint->resolved_at->format('d M Y H:i') }}</small>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Timeline --}}
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-primary"></i>Status Timeline</h6>
            </div>
            <div class="card-body">
                <div class="timeline">
                    @forelse($complaint->logs as $log)
                    <div class="timeline-item {{ $log->status === 'resolved' || $log->status === 'closed' ? 'success' : ($log->status === 'escalated' ? 'danger' : 'info') }}">
                        <div class="fw-semibold small">{{ ucfirst($log->status) }}</div>
                        <div class="text-muted small mb-1">{{ $log->comment }}</div>
                        <div class="text-muted" style="font-size:.7rem">
                            <i class="bi bi-person me-1"></i> {{ $log->user->name ?? 'System' }} • 
                            <i class="bi bi-clock me-1"></i> {{ $log->created_at->format('d M Y H:i') }}
                        </div>
                    </div>
                    @empty
                    <div class="timeline-item">
                        <div class="fw-semibold small">Complaint Submitted</div>
                        <div class="text-muted" style="font-size:.75rem">{{ $complaint->created_at->format('d M Y H:i') }}</div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- Right: Actions --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">Quick Info</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Status</span>
                        <span>{!! $complaint->status_badge !!}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Priority</span>
                        <span>{!! $complaint->priority_badge !!}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Category</span>
                        <span class="fw-semibold small">{{ $complaint->category->name ?? '—' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Submitted</span>
                        <span class="fw-semibold small">{{ $complaint->created_at->format('d M Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2">
                        <span class="text-muted small">Last Updated</span>
                        <span class="fw-semibold small">{{ $complaint->updated_at->diffForHumans() }}</span>
                    </li>
                </ul>
            </div>
        </div>

<<<<<<< HEAD
        @if($complaint->status === 'pending')
=======
        @if($complaint->status === 'open')
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <div class="card">
            <div class="card-body d-grid gap-2">
                <a href="{{ route('resident.complaints.edit', $complaint) }}" class="btn btn-outline-primary">
                    <i class="bi bi-pencil me-2"></i>Edit Complaint
                </a>
                <form method="POST" action="{{ route('resident.complaints.destroy', $complaint) }}"
                      onsubmit="return confirm('Delete this complaint permanently?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Delete Complaint
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
