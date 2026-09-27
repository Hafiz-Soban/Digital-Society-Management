@extends('layouts.admin')
@section('title', 'Visitors Report')
@section('page-title', 'Visitors Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Visitors Report</h5>
        <p class="text-muted small mb-0">Detailed visitor analysis and entry statistics</p>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Reports
    </a>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-funnel me-2"></i>Filter Report</h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Search Visitor</label>
                <input type="text" name="search" class="form-control" placeholder="Name or phone..." value="{{ request('search') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Generate</button>
                <a href="{{ route('admin.reports.visitors') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Stats Summary -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-person-badge text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total Visitors</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-check-circle text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['approved'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Approved</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-x-circle text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['denied'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Denied</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-box-arrow-in-right text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['checked_in'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Checked In</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Results Table -->
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Results</h6>
        <span class="badge bg-secondary">{{ $visitors->total() }} records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Visitor Name</th>
                        <th>Phone</th>
                        <th>Resident / House</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Arrival</th>
                        <th>Checkout</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $visitor)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $visitor->visitor_name }}</div>
                            @if($visitor->vehicle_number)
                                <div class="text-muted small"><i class="bi bi-car-front me-1"></i>{{ $visitor->vehicle_number }}</div>
                            @endif
                        </td>
                        <td>{{ $visitor->visitor_phone ?? '-' }}</td>
                        <td>
                            @if($visitor->resident)
                                <div class="small fw-semibold">{{ $visitor->resident->user->name }}</div>
                                <div class="text-muted small">{{ $visitor->resident->house->house_number ?? '-' }}</div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($visitor->purpose, 40) }}</td>
                        <td>{!! $visitor->status_badge !!}</td>
                        <td>{{ $visitor->actual_arrival?->format('d M Y H:i') ?? $visitor->expected_arrival?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $visitor->checkout_time?->format('d M Y H:i') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-person-badge fs-1 d-block mb-2"></i>
                            No visitors match the selected filters
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($visitors->hasMorePages())
=======
    @if($visitors->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $visitors->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
