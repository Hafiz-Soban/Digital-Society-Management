@extends('layouts.resident')
@section('title','My Visitors')
@section('page-title','Visitor Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">My Visitors</h5>
        <p class="text-muted small mb-0">Manage visitor requests and track entry history</p>
    </div>
    <a href="{{ route('resident.visitors.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add Visitor
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
            <div class="fw-bold fs-4 text-success">{{ $stats['approved'] }}</div>
            <div class="text-muted small">Approved</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-info">{{ $stats['checked_in'] }}</div>
            <div class="text-muted small">Checked In</div>
        </div>
    </div>
</div>

{{-- Search & Filter --}}
<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Search by name, phone, purpose…" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="pending"    {{ request('status')=='pending'    ? 'selected':'' }}>Pending</option>
                    <option value="approved"   {{ request('status')=='approved'   ? 'selected':'' }}>Approved</option>
                    <option value="denied"     {{ request('status')=='denied'     ? 'selected':'' }}>Denied</option>
                    <option value="checked_in" {{ request('status')=='checked_in' ? 'selected':'' }}>Checked In</option>
                    <option value="checked_out"{{ request('status')=='checked_out'? 'selected':'' }}>Checked Out</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('resident.visitors.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                        <th>Visitor</th>
                        <th>Purpose</th>
                        <th>Expected Arrival</th>
                        <th>Vehicle</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $visitor)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $visitor->visitor_name }}</div>
                            <div class="text-muted small">{{ $visitor->visitor_phone ?? '—' }}</div>
                        </td>
                        <td>{{ Str::limit($visitor->purpose, 30) }}</td>
                        <td>
                            @if($visitor->expected_arrival)
                                <div>{{ $visitor->expected_arrival->format('d M Y') }}</div>
                                <div class="text-muted small">{{ $visitor->expected_arrival->format('H:i') }}</div>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>{{ $visitor->vehicle_number ?? '—' }}</td>
                        <td>{!! $visitor->status_badge !!}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('resident.visitors.show', $visitor) }}"
                                   class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if(in_array($visitor->status, ['pending','approved']))
                                <a href="{{ route('resident.visitors.edit', $visitor) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('resident.visitors.cancel', $visitor) }}"
                                      onsubmit="return confirm('Cancel this visitor request?')">
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
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-person-badge d-block fs-1 mb-2"></i>
                            No visitor requests found.
                            <div class="mt-2">
                                <a href="{{ route('resident.visitors.create') }}" class="btn btn-sm btn-primary">
                                    Add Your First Visitor
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
    @if($visitors->hasMorePages())
=======
    @if($visitors->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">{{ $visitors->links() }}</div>
    @endif
</div>
@endsection
