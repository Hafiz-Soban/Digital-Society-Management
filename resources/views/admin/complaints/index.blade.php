@extends('layouts.admin')
@section('title', 'Complaints')
@section('page-title', 'Complaint Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Complaints</h5>
        <p class="text-muted small mb-0">Manage and resolve resident complaints</p>
    </div>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-exclamation-circle text-white"></i>
                </div>
                <div>
<<<<<<< HEAD
                    <div class="stat-value">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Pending</div>
=======
                    <div class="stat-value">{{ $stats['open'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Open</div>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-hourglass-split text-white"></i>
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
                    <div class="stat-value">{{ $stats['resolved'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Resolved</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-chat-square-text text-white"></i>
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
                    <input type="text" name="search" class="form-control" placeholder="Search by title, complaint #, resident..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
<<<<<<< HEAD
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                    <option value="escalated" {{ request('status') == 'escalated' ? 'selected' : '' }}>Escalated</option>
=======
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
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
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                        <th>Complaint #</th>
                        <th>Title</th>
                        <th>Resident</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned To</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        <td><code>{{ $complaint->complaint_number }}</code></td>
                        <td>
                            <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-decoration-none fw-semibold">
                                {{ Str::limit($complaint->title, 40) }}
                            </a>
                        </td>
                        <td>
                            @if($complaint->resident)
                                <div class="small fw-semibold">{{ $complaint->resident->user->name }}</div>
                                <div class="text-muted small">{{ $complaint->resident->house->house_number ?? '-' }}</div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>{{ $complaint->category->name ?? '-' }}</td>
                        <td>{!! $complaint->priority_badge !!}</td>
                        <td>{!! $complaint->status_badge !!}</td>
                        <td>{{ $complaint->assignedTo->name ?? '<span class="text-muted small">Unassigned</span>' }}</td>
                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                        <td>
                            <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-outline-info" title="View">
                                <i class="bi bi-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-chat-square-text fs-1 d-block mb-2"></i>
                            No complaints found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($complaints->hasMorePages())
=======
    @if($complaints->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $complaints->links() }}
    </div>
    @endif
</div>
@endsection
