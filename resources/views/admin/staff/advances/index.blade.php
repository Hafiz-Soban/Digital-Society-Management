@extends('layouts.admin')

@section('title', 'Advance Salary Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Advance Salary Management</h2>
        <a href="{{ route('admin.staff-advances.create') }}" class="btn btn-primary">
            <i class="bi bi-cash me-2"></i>Give Advance
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.staff-advances.index') }}" method="GET" class="row g-3">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search staff name..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <select name="staff_id" class="form-select">
                        <option value="">All Staff</option>
                        @foreach($staffMembers as $staff)
                            <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>{{ $staff->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-dark w-100">Filter History</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Staff Name</th>
                        <th>Advance Amount</th>
                        <th>Date</th>
                        <th>Reason</th>
                        <th>Approved By</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($advances as $advance)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $advance->staff->full_name }}</div>
                            <small class="text-muted">{{ $advance->staff->employee_id }}</small>
                        </td>
                        <td class="text-danger fw-bold">Rs. {{ number_format($advance->amount, 2) }}</td>
                        <td>{{ $advance->advance_date->format('d M, Y') }}</td>
                        <td>{{ Str::limit($advance->reason, 30) }}</td>
                        <td>{{ $advance->approver->name }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.staff.show', $advance->staff_id) }}" class="btn btn-sm btn-outline-primary">View Profile</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No advance salary records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($advances->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $advances->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
