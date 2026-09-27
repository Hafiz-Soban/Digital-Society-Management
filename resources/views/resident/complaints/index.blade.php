@extends('layouts.resident')
@section('title','My Complaints')
@section('page-title','Complaint Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">My Complaints</h5>
        <p class="text-muted small mb-0">Submit and track your complaints</p>
    </div>
    <a href="{{ route('resident.complaints.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-2"></i>New Complaint
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
<<<<<<< HEAD
            <div class="fw-bold fs-4 text-danger">{{ $stats['pending'] }}</div>
            <div class="text-muted small">Pending</div>
=======
            <div class="fw-bold fs-4 text-danger">{{ $stats['open'] }}</div>
            <div class="text-muted small">Open</div>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-warning">{{ $stats['in_progress'] }}</div>
            <div class="text-muted small">In Progress</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-success">{{ $stats['resolved'] }}</div>
            <div class="text-muted small">Resolved</div>
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
<<<<<<< HEAD
                    <option value="pending"     {{ request('status')=='pending'     ?'selected':'' }}>Pending</option>
=======
                    <option value="open"        {{ request('status')=='open'        ?'selected':'' }}>Open</option>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    <option value="in_progress" {{ request('status')=='in_progress' ?'selected':'' }}>In Progress</option>
                    <option value="resolved"    {{ request('status')=='resolved'    ?'selected':'' }}>Resolved</option>
                    <option value="closed"      {{ request('status')=='closed'      ?'selected':'' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <select name="category_id" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id')==$cat->id?'selected':'' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('resident.complaints.index') }}" class="btn btn-outline-secondary w-100">
                    <i class="bi bi-x"></i>
                </a>
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
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $complaint)
                    <tr>
                        <td>
                            <a href="{{ route('resident.complaints.show', $complaint) }}"
                               class="text-decoration-none fw-semibold text-primary">
                                {{ $complaint->complaint_number }}
                            </a>
                        </td>
                        <td>{{ Str::limit($complaint->title, 35) }}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ $complaint->category->name ?? '—' }}
                            </span>
                        </td>
                        <td>{!! $complaint->priority_badge !!}</td>
                        <td>{!! $complaint->status_badge !!}</td>
                        <td class="text-muted small">{{ $complaint->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('resident.complaints.show', $complaint) }}"
                                   class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
<<<<<<< HEAD
                                @if($complaint->status === 'pending')
=======
                                @if($complaint->status === 'open')
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                                <a href="{{ route('resident.complaints.edit', $complaint) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('resident.complaints.destroy', $complaint) }}"
                                      onsubmit="return confirm('Delete this complaint?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-chat-square d-block fs-1 mb-2"></i>
                            No complaints found.
                            <div class="mt-2">
                                <a href="{{ route('resident.complaints.create') }}" class="btn btn-sm btn-primary">
                                    Submit Your First Complaint
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
    @if($complaints->hasMorePages())
=======
    @if($complaints->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">{{ $complaints->links() }}</div>
    @endif
</div>
@endsection
