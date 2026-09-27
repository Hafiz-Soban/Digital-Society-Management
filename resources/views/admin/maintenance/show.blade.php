@extends('layouts.admin')
@section('title', 'Maintenance Request Details')
@section('page-title', 'Maintenance Request Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Request — <code>{{ $request->request_number }}</code></h5>
        <p class="text-muted small mb-0">View details, assign staff and update status</p>
    </div>
    <a href="{{ route('admin.maintenance.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Maintenance
    </a>
</div>

<div class="row g-4">
    <!-- Request Details -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-tools me-2 text-primary"></i>Request Details</h6>
                <div class="d-flex gap-2">
                    {!! $request->priority_badge !!}
                    {!! $request->status_badge !!}
                </div>
            </div>
            <div class="card-body">
                <h5 class="fw-bold mb-3">{{ $request->title }}</h5>

                <div class="row g-3 mb-4">
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Category</div>
                            <div class="fw-semibold">{{ ucfirst($request->category ?? '-') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">House</div>
                            <div class="fw-semibold">{{ $request->house->house_number ?? '-' }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Submitted</div>
                            <div class="fw-semibold">{{ $request->created_at->format('d M Y') }}</div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="bg-light rounded-3 p-3 text-center">
                            <div class="text-muted small">Scheduled</div>
                            <div class="fw-semibold">{{ $request->scheduled_date?->format('d M Y') ?? 'Not set' }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <h6 class="fw-semibold text-muted small text-uppercase mb-2">Description</h6>
                    <p class="mb-0">{{ $request->description }}</p>
                </div>

                @if($request->completion_notes)
                <div class="alert alert-success">
                    <h6 class="fw-semibold mb-1"><i class="bi bi-check-circle me-2"></i>Completion Notes</h6>
                    <p class="mb-0">{{ $request->completion_notes }}</p>
                    @if($request->completed_at)
                        <small class="text-muted">Completed on {{ $request->completed_at->format('d M Y H:i') }}</small>
                    @endif
                </div>
                @endif
            </div>
        </div>

        <!-- Assign Staff Form -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-gear me-2 text-info"></i>Assign Staff</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.maintenance.assign', $request) }}">
                    @csrf @method('PATCH')
                    <div class="row g-3 align-items-end">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Assign Staff Member</label>
                            <select name="staff_id" class="form-select @error('staff_id') is-invalid @enderror">
                                <option value="">Select Staff Member</option>
                                @foreach($staff ?? [] as $member)
                                    <option value="{{ $member->id }}" {{ $request->staff_id == $member->id ? 'selected' : '' }}>
                                        {{ $member->name }} — {{ ucfirst($member->specialization ?? 'General') }}
                                    </option>
                                @endforeach
                            </select>
                            @error('staff_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Scheduled Date</label>
                            <input type="date" name="scheduled_date" class="form-control"
                                value="{{ old('scheduled_date', $request->scheduled_date?->format('Y-m-d')) }}">
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info text-white w-100">
                                <i class="bi bi-person-check me-1"></i>Assign
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
                <form method="POST" action="{{ route('admin.maintenance.status', $request) }}">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="pending" {{ $request->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="assigned" {{ $request->status == 'assigned' ? 'selected' : '' }}>Assigned</option>
                                <option value="in_progress" {{ $request->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ $request->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ $request->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priority</label>
                            <select name="priority" class="form-select">
                                <option value="">Keep Current</option>
                                <option value="low" {{ $request->priority == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ $request->priority == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ $request->priority == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ $request->priority == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Completion / Work Notes</label>
                            <textarea name="completion_notes" class="form-control @error('completion_notes') is-invalid @enderror"
                                rows="3" placeholder="Add work notes or completion details...">{{ old('completion_notes', $request->completion_notes) }}</textarea>
                            @error('completion_notes')
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

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Resident Info -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-success"></i>Requested By</h6>
            </div>
            <div class="card-body">
                @if($request->resident)
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $request->resident->user->avatar_url }}" class="rounded-circle" width="48" height="48" alt="">
                        <div>
                            <div class="fw-semibold">{{ $request->resident->user->name }}</div>
                            <div class="text-muted small">{{ $request->resident->user->phone ?? '-' }}</div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted small">House</span>
                            <span class="fw-semibold">{{ $request->house->house_number ?? '-' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted small">Block</span>
                            <span class="fw-semibold">{{ $request->house->block ?? '-' }}</span>
                        </li>
                    </ul>
                @else
                    <p class="text-muted mb-0 small">No resident linked</p>
                @endif
            </div>
        </div>

        <!-- Assigned Staff -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-gear me-2 text-info"></i>Assigned Staff</h6>
            </div>
            <div class="card-body">
                @if($request->assignedStaff)
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width:48px;height:48px">
                            <i class="bi bi-person-fill text-info fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $request->assignedStaff->name }}</div>
                            <div class="text-muted small">{{ ucfirst($request->assignedStaff->specialization ?? 'General') }}</div>
                            <div class="text-muted small">{{ $request->assignedStaff->phone ?? '-' }}</div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-2 text-muted">
                        <i class="bi bi-person-x fs-3 d-block mb-1"></i>
                        <small>No staff assigned yet</small>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
