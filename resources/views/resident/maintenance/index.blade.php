@extends('layouts.resident')
@section('title','Maintenance Requests')
@section('page-title','Maintenance Requests')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Maintenance Requests</h5>
        <p class="text-muted small mb-0">Submit and track maintenance work for your house</p>
    </div>
    <a href="{{ route('resident.maintenance.create') }}" class="btn btn-primary">
        <i class="bi bi-tools me-2"></i>New Request
    </a>
</div>

{{-- Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-primary">{{ $stats['total'] }}</div>
            <div class="text-muted small">Total</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-warning">{{ $stats['pending'] }}</div>
            <div class="text-muted small">Pending</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-info">{{ $stats['in_progress'] }}</div>
            <div class="text-muted small">In Progress</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-success">{{ $stats['completed'] }}</div>
            <div class="text-muted small">Completed</div>
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Search by title or number…" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending"     {{ request('status')=='pending'     ?'selected':'' }}>Pending</option>
                    <option value="assigned"    {{ request('status')=='assigned'    ?'selected':'' }}>Assigned</option>
                    <option value="in_progress" {{ request('status')=='in_progress' ?'selected':'' }}>In Progress</option>
                    <option value="completed"   {{ request('status')=='completed'   ?'selected':'' }}>Completed</option>
                    <option value="cancelled"   {{ request('status')=='cancelled'   ?'selected':'' }}>Cancelled</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach(['plumbing','electrical','carpentry','painting','cleaning','other'] as $cat)
                    <option value="{{ $cat }}" {{ request('category')==$cat?'selected':'' }}>{{ ucfirst($cat) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('resident.maintenance.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Table --}}
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Number</th>
                        <th>Title</th>
                        <th>Category</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th>Assigned Staff</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                    <tr>
                        <td>
                            <a href="{{ route('resident.maintenance.show', $req) }}"
                               class="text-decoration-none fw-semibold text-warning">
                                {{ $req->request_number }}
                            </a>
                        </td>
                        <td>{{ Str::limit($req->title, 30) }}</td>
                        <td><span class="badge bg-light text-dark border">{{ ucfirst($req->category) }}</span></td>
                        <td>{!! $req->priority_badge !!}</td>
                        <td>{!! $req->status_badge !!}</td>
                        <td>
                            @if($req->assignedStaff)
                                <div class="fw-semibold small">{{ $req->assignedStaff->name }}</div>
                                <div class="text-muted" style="font-size:.72rem">{{ ucfirst($req->assignedStaff->specialization) }}</div>
                            @else
                                <span class="text-muted small">Unassigned</span>
                            @endif
                        </td>
                        <td class="text-muted small">{{ $req->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('resident.maintenance.show', $req) }}"
                                   class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($req->status === 'pending')
                                <a href="{{ route('resident.maintenance.edit', $req) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('resident.maintenance.cancel', $req) }}"
                                      onsubmit="return confirm('Cancel this request?')">
                                    @csrf @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Cancel">
                                        <i class="bi bi-x-circle"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-tools d-block fs-1 mb-2"></i>
                            No maintenance requests found.
                            <div class="mt-2">
                                <a href="{{ route('resident.maintenance.create') }}" class="btn btn-sm btn-primary">
                                    Submit Your First Request
                                </a>
                            </div>
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
    <div class="card-footer bg-white">{{ $requests->links() }}</div>
    @endif
</div>
@endsection
