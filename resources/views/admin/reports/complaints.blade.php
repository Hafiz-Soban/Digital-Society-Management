@extends('layouts.admin')
@section('title', 'Complaints Report')
@section('page-title', 'Complaints Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Complaints Report</h5>
        <p class="text-muted small mb-0">Detailed complaint analysis and resolution statistics</p>
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
            <div class="col-md-2">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
<<<<<<< HEAD
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
=======
                    <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>Open</option>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                    <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>Resolved</option>
                    <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Priority</label>
                <select name="priority" class="form-select">
                    <option value="">All Priority</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="medium" {{ request('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">Category</label>
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories ?? [] as $category)
                        <option value="{{ $category->id }}" {{ request('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
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
                <a href="{{ route('admin.reports.complaints') }}" class="btn btn-outline-secondary">Reset</a>
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
                    <i class="bi bi-chat-square-text text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total</div>
                </div>
            </div>
        </div>
    </div>
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
</div>

<!-- Results Table -->
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Results</h6>
        <span class="badge bg-secondary">{{ $complaints->total() }} records</span>
    </div>
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
                        <th>Filed On</th>
                        <th>Resolved On</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        <td><code>{{ $complaint->complaint_number }}</code></td>
                        <td>{{ Str::limit($complaint->title, 35) }}</td>
                        <td>
                            <div class="small fw-semibold">{{ $complaint->resident->user->name ?? '-' }}</div>
                            <div class="text-muted small">{{ $complaint->resident->house->house_number ?? '-' }}</div>
                        </td>
                        <td>{{ $complaint->category->name ?? '-' }}</td>
                        <td>{!! $complaint->priority_badge !!}</td>
                        <td>{!! $complaint->status_badge !!}</td>
                        <td>{{ $complaint->assignedTo->name ?? '-' }}</td>
                        <td>{{ $complaint->created_at->format('d M Y') }}</td>
                        <td>{{ $complaint->resolved_at?->format('d M Y') ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-chat-square-text fs-1 d-block mb-2"></i>
                            No complaints match the selected filters
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
        {{ $complaints->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
