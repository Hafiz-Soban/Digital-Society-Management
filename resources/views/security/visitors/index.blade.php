@extends('layouts.security')
@section('title', 'Visitor Logs')
@section('page-title', 'Visitor Logs')

@section('content')
<div class="card mb-4">
    <div class="card-body">
        <form action="{{ route('security.visitors.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Search</label>
                <div class="input-group">
                    <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Name, CNIC, Phone, Vehicle..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="checked_in" {{ request('status') == 'checked_in' ? 'selected' : '' }}>Checked In</option>
                    <option value="checked_out" {{ request('status') == 'checked_out' ? 'selected' : '' }}>Checked Out</option>
                    <option value="denied" {{ request('status') == 'denied' ? 'selected' : '' }}>Denied</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Date</label>
                <input type="date" name="date" class="form-control" value="{{ request('date') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold">Visitor Records</h6>
        <a href="{{ route('security.visitors.create') }}" class="btn btn-sm btn-danger"><i class="bi bi-plus-lg me-1"></i>New Entry</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-3">Visitor Info</th>
                        <th>Resident / House</th>
                        <th>Purpose</th>
                        <th>Entry/Exit Time</th>
                        <th>Status</th>
                        <th class="text-end pe-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visitors as $visitor)
                    <tr>
                        <td class="ps-3">
                            <div class="fw-bold">{{ $visitor->visitor_name }}</div>
                            <small class="text-muted d-block">CNIC: {{ $visitor->visitor_cnic ?? 'N/A' }}</small>
                            <small class="text-muted d-block">Phone: {{ $visitor->visitor_phone ?? 'N/A' }}</small>
                        </td>
                        <td>
                            <div>{{ $visitor->resident->user->name ?? 'N/A' }}</div>
                            <small class="text-muted">House: {{ $visitor->resident->house->house_number ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $visitor->purpose }}</td>
                        <td>
                            <div class="small">In: {{ $visitor->actual_arrival ? $visitor->actual_arrival->format('d M, H:i') : '—' }}</div>
                            <div class="small text-muted">Out: {{ $visitor->departure_time ? $visitor->departure_time->format('d M, H:i') : '—' }}</div>
                        </td>
                        <td>{!! $visitor->status_badge !!}</td>
                        <td class="text-end pe-3">
                            <div class="btn-group">
                                <a href="{{ route('security.visitors.show', $visitor) }}" class="btn btn-sm btn-outline-secondary" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
                                @if($visitor->status == 'pending')
                                    <form action="{{ route('security.visitors.approve', $visitor) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Approve Entry">
                                            <i class="bi bi-check-lg"></i>
                                        </button>
                                    </form>
                                    <form action="{{ route('security.visitors.deny', $visitor) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Deny Entry">
                                            <i class="bi bi-x-lg"></i>
                                        </button>
                                    </form>
                                @endif
                                @if($visitor->status == 'checked_in')
                                    <form action="{{ route('security.visitors.checkout', $visitor) }}" method="POST" class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-outline-warning" title="Record Exit">
                                            <i class="bi bi-box-arrow-right"></i>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No visitor records found</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">
        {{ $visitors->links() }}
    </div>
</div>
@endsection
