@extends('layouts.admin')
@section('title', 'Complaint Details')
@section('page-title', 'Complaint Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Complaint — <code>{{ $complaint->complaint_number }}</code></h5>
        <p class="text-muted small mb-0">View details, assign staff and update status</p>
    </div>
    <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Complaints
    </a>
</div>

<div class="row g-4">
    <!-- Complaint Details -->
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
                        <div class="bg-light rounded-3 p-3">
                            <div class="text-muted small">Category</div>
                            <div class="fw-semibold">{{ $complaint->category->name ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light rounded-3 p-3">
                            <div class="text-muted small">Submitted</div>
                            <div class="fw-semibold">{{ $complaint->created_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="bg-light rounded-3 p-3">
                            <div class="text-muted small">Last Updated</div>
                            <div class="fw-semibold">{{ $complaint->updated_at->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold text-muted small text-uppercase mb-2">Description</h6>
                    <p class="mb-0">{{ $complaint->description }}</p>
                </div>

                @if($complaint->resolution_notes)
                <div class="alert alert-success">
                    <h6 class="fw-semibold mb-1"><i class="bi bi-check-circle me-2"></i>Resolution Notes</h6>
                    <p class="mb-0">{{ $complaint->resolution_notes }}</p>
                    @if($complaint->resolved_at)
                        <small class="text-muted">Resolved on {{ $complaint->resolved_at->format('d M Y H:i') }}</small>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Assign Form -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-check me-2 text-info"></i>Assign to Admin</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.complaints.assign', $complaint) }}">
                    @csrf @method('PATCH')
                    <div class="row g-3 align-items-end">
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">Assign To</label>
                            <select name="assigned_to" class="form-select @error('assigned_to') is-invalid @enderror">
                                <option value="">Select Admin User</option>
<<<<<<< HEAD
                                @foreach($admins as $admin)
=======
                                @foreach($adminUsers ?? [] as $admin)
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                                    <option value="{{ $admin->id }}" {{ $complaint->assigned_to == $admin->id ? 'selected' : '' }}>
                                        {{ $admin->name }} ({{ $admin->role->name ?? 'Admin' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('assigned_to')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-info text-white w-100">
                                <i class="bi bi-person-check me-2"></i>Assign
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Status Update Form -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-arrow-repeat me-2 text-warning"></i>Update Status</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.complaints.status', $complaint) }}">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
<<<<<<< HEAD
                                <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                <option value="escalated" {{ $complaint->status == 'escalated' ? 'selected' : '' }}>Escalated</option>
=======
                                <option value="open" {{ $complaint->status == 'open' ? 'selected' : '' }}>Open</option>
                                <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>Closed</option>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="">Keep Current</option>
                                <option value="low" {{ $complaint->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $complaint->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $complaint->priority == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $complaint->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Resolution Notes</label>
                            <textarea name="resolution_notes" class="form-control @error('resolution_notes') is-invalid @enderror"
                                rows="3" placeholder="Add resolution notes or comments...">{{ old('resolution_notes', $complaint->resolution_notes) }}</textarea>
                            @error('resolution_notes')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar Info -->
    <div class="col-lg-4">
        <!-- Resident Info -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-success"></i>Submitted By</h6>
            </div>
            <div class="card-body">
                @if($complaint->resident)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $complaint->resident->user->avatar_url }}" class="rounded-circle" width="48" height="48" alt="">
                        <div>
                            <div class="fw-semibold">{{ $complaint->resident->user->name }}</div>
                            <div class="text-muted small">{{ $complaint->resident->user->email }}</div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted small">House</span>
                            <span class="fw-semibold">{{ $complaint->resident->house->house_number ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted small">Phone</span>
                            <span class="fw-semibold">{{ $complaint->resident->user->phone ?? '-' }}</span>
                        </li>
                    </ul>
                    <div class="mt-3">
                        <a href="{{ route('admin.residents.show', $complaint->resident) }}" class="btn btn-sm btn-outline-primary w-100">
                            View Profile
                        </a>
                    </div>
                @else
                    <p class="text-muted mb-0 small">No resident linked</p>
                @endif
            </div>
        </div>

        <!-- Assigned To -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-check me-2 text-info"></i>Assigned To</h6>
            </div>
            <div class="card-body">
                @if($complaint->assignedTo)
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">
                            <i class="bi bi-person-fill text-info fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $complaint->assignedTo->name }}</div>
                            <div class="text-muted small">{{ $complaint->assignedTo->role->name ?? 'Admin' }}</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-2 text-muted">
                        <i class="bi bi-person-x fs-3 d-block mb-1"></i>
                        <small>Not assigned yet</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
