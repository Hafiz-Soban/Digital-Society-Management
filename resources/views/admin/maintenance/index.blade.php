@extends('layouts.admin')
@section('title', 'Maintenance Requests')
@section('page-title', 'Maintenance Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Maintenance Requests</h5>
        <p class="text-muted small mb-0">Track and manage all maintenance work orders</p>
    </div>
    <a href="{{ route('admin.maintenance.staff') }}" class="btn btn-outline-secondary">
        <i class="bi bi-people me-2"></i>Manage Staff
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-exclamation-triangle text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Pending</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-tools text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['in_progress'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">In Progress</div>
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
                    <div class="stat-value">{{ $stats['completed'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Completed</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-clipboard-list text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total</div>
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
                    <input type="text" name="search" class="form-control" placeholder="Search by title, request #, house..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="assigned" {{ request('status') == 'assigned' ? 'selected' : '' }}>Assigned</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="priority" class="form-select">
                    <option value="">All Priority</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    <option value="plumbing" {{ request('category') == 'plumbing' ? 'selected' : '' }}>Plumbing</option>
                    <option value="electrical" {{ request('category') == 'electrical' ? 'selected' : '' }}>Electrical</option>
                    <option value="carpentry" {{ request('category') == 'carpentry' ? 'selected' : '' }}>Carpentry</option>
                    <option value="painting" {{ request('category') == 'painting' ? 'selected' : '' }}>Painting</option>
                    <option value="cleaning" {{ request('category') == 'cleaning' ? 'selected' : '' }}>Cleaning</option>
                    <option value="other" {{ request('category') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.maintenance.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                        <th>Request #</th>
                        <th>Title</th>
                        <th>House</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned Staff</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr>
                        <td><code>{{ $request->request_number }}</code></td>
                        <td>
                            <a href="{{ route('admin.maintenance.show', $request) }}" class="text-decoration-none fw-semibold">
                                {{ Str::limit($request->title, 35) }}
                            </a>
                        </td>
                        <td>{{ $request->house->house_number ?? '-' }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($request->category ?? '-') }}</span>
                        </td>
                        <td>{!! $request->priority_badge !!}</td>
                        <td>{!! $request->status_badge !!}</td>
                        <td>{{ $request->assignedStaff->name ?? '<span class="text-muted small">Unassigned</span>' }}</td>
                        <td>{{ $request->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.maintenance.show', $request) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-tools fs-1 d-block mb-2"></i>
                            No maintenance requests found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($requests->hasMorePages())
=======
    @if($requests->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $requests->links() }}
    </div>
    @endif
</div>
@endsection
