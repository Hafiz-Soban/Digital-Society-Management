@extends('layouts.admin')
@section('title', 'Visitors')
@section('page-title', 'Visitor Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Visitor Logs</h5>
        <p class="text-muted small mb-0">Track and manage all visitor entries</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-people text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total Visitors</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-clock text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Pending</div>
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
                    <div class="stat-value">{{ $stats['checked_in'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Checked In</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-secondary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-box-arrow-right text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['checked_out'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Checked Out</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name or phone..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}" placeholder="From date">
            </div>
            <div class="col-md-2">
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}" placeholder="To date">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.visitors.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Visitor</th>
                        <th>Phone</th>
                        <th>Resident / House</th>
                        <th>Purpose</th>
                        <th>Status</th>
                        <th>Arrival Time</th>
                        <th>Actions</th>
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
                                <div class="fw-semibold small">{{ $visitor->resident->user->name }}</div>
                                <div class="text-muted small">{{ $visitor->resident->house->house_number ?? '-' }}</div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ Str::limit($visitor->purpose, 40) }}</td>
                        <td>{!! $visitor->status_badge !!}</td>
                        <td>
                            <div>{{ $visitor->expected_arrival?->format('d M Y') ?? '-' }}</div>
                            @if($visitor->actual_arrival)
                                <div class="text-muted small">In: {{ $visitor->actual_arrival->format('H:i') }}</div>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.visitors.show', $visitor) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-person-badge fs-1 d-block mb-2"></i>
                            No visitor records found
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
        {{ $visitors->links() }}
    </div>
    @endif
</div>
@endsection
