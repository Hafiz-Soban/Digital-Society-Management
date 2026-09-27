@extends('layouts.admin')
@section('title', 'Visitor Details')
@section('page-title', 'Visitor Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Visitor — {{ $visitor->visitor_name }}</h5>
        <p class="text-muted small mb-0">Full visitor information and status management</p>
    </div>
    <a href="{{ route('admin.visitors.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Visitors
    </a>
</div>

<div class="row g-4">
    <!-- Visitor Info -->
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-badge me-2 text-primary"></i>Visitor Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px">
                        <i class="bi bi-person-fill text-primary fs-1"></i>
                    </div>
                    <h5 class="fw-bold mb-1">{{ $visitor->visitor_name }}</h5>
                    <div>{!! $visitor->status_badge !!}</div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Phone</span>
                        <span class="fw-semibold">{{ $visitor->visitor_phone ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">CNIC / ID</span>
                        <span class="fw-semibold">{{ $visitor->visitor_cnic ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Vehicle No.</span>
                        <span class="fw-semibold">{{ $visitor->vehicle_number ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Purpose</span>
                        <span class="fw-semibold">{{ $visitor->purpose ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Expected Arrival</span>
                        <span class="fw-semibold">{{ $visitor->expected_arrival?->format('d M Y H:i') ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Actual Arrival</span>
                        <span class="fw-semibold">{{ $visitor->actual_arrival?->format('d M Y H:i') ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Checkout Time</span>
                        <span class="fw-semibold">{{ $visitor->checkout_time?->format('d M Y H:i') ?? '-' }}</span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Resident Info -->
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-house me-2 text-success"></i>Visiting Resident</h6>
            </div>
            <div class="card-body">
                @if($visitor->resident)
                    <div class="d-flex align-items-center gap-3">
                        <img src="{{ $visitor->resident->user->avatar_url }}" class="rounded-circle" width="48" height="48" alt="">
                        <div>
                            <div class="fw-semibold">{{ $visitor->resident->user->name }}</div>
                            <div class="text-muted small">{{ $visitor->resident->user->phone ?? '-' }}</div>
                            <div class="text-muted small">House: {{ $visitor->resident->house->house_number ?? '-' }}</div>
                        </div>
                    </div>
                @else
                    <p class="text-muted mb-0 small">No resident linked</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Update -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-arrow-repeat me-2 text-warning"></i>Update Status</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">Current status: {!! $visitor->status_badge !!}</p>

                <form method="POST" action="{{ route('admin.visitors.status', $visitor) }}">
                    @csrf @method('PATCH')

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="">Select Status</option>
                                <option value="approved" {{ $visitor->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                <option value="denied" {{ $visitor->status == 'denied' ? 'selected' : '' }}>Deny</option>
                                <option value="checked_in" {{ $visitor->status == 'checked_in' ? 'selected' : '' }}>Check In</option>
                                <option value="checked_out" {{ $visitor->status == 'checked_out' ? 'selected' : '' }}>Check Out</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Notes</label>
                            <input type="text" name="notes" class="form-control" placeholder="Optional notes..." value="{{ old('notes') }}">
                        </div>
                    </div>

                    <div class="mt-3 d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Update Status
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Quick Action Buttons -->
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-lightning me-2 text-info"></i>Quick Actions</h6>
            </div>
            <div class="card-body">
                <div class="d-flex flex-wrap gap-2">
                    @if($visitor->status == 'pending')
                    <form method="POST" action="{{ route('admin.visitors.status', $visitor) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="approved">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.visitors.status', $visitor) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="denied">
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-x-circle me-2"></i>Deny
                        </button>
                    </form>
                    @endif

                    @if($visitor->status == 'approved')
                    <form method="POST" action="{{ route('admin.visitors.status', $visitor) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="checked_in">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Check In
                        </button>
                    </form>
                    @endif

                    @if($visitor->status == 'checked_in')
                    <form method="POST" action="{{ route('admin.visitors.status', $visitor) }}">
                        @csrf @method('PATCH')
                        <input type="hidden" name="status" value="checked_out">
                        <button type="submit" class="btn btn-secondary">
                            <i class="bi bi-box-arrow-right me-2"></i>Check Out
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Notes / History -->
        @if($visitor->notes)
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-journal-text me-2 text-secondary"></i>Notes</h6>
            </div>
            <div class="card-body">
                <p class="mb-0">{{ $visitor->notes }}</p>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
