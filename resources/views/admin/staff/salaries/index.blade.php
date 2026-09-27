@extends('layouts.admin')

@section('title', 'Salary Management')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Salary Management</h2>
        <a href="{{ route('admin.staff-salaries.create') }}" class="btn btn-primary">
            <i class="bi bi-cash-stack me-2"></i>Record Salary Payment
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.staff-salaries.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Staff Member</label>
                    <select name="staff_id" class="form-select">
                        <option value="">All Staff</option>
                        @foreach($staffMembers as $staff)
                            <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>{{ $staff->full_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Month</label>
                    <input type="text" name="month" class="form-control" placeholder="e.g. June 2026" value="{{ request('month') }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark w-100">Filter</button>
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
                        <th>Month</th>
                        <th>Salary Amount</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salaries as $salary)
                    <tr>
                        <td>
                            <div class="fw-bold">{{ $salary->staff->full_name }}</div>
                            <small class="text-muted">{{ $salary->staff->employee_id }}</small>
                        </td>
                        <td>{{ $salary->month }}</td>
                        <td>Rs. {{ number_format($salary->amount, 2) }}</td>
                        <td>{{ $salary->payment_date ? $salary->payment_date->format('d M, Y') : '-' }}</td>
                        <td>
                            @if($salary->status == 'paid')
                                <span class="badge bg-success">Paid</span>
                            @else
                                <span class="badge bg-warning">Pending</span>
                            @endif
                        </td>
                        <td class="text-end">
                            @if($salary->status == 'pending')
                            <form action="{{ route('admin.staff-salaries.update', $salary) }}" method="POST" class="d-inline">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="status" value="paid">
                                <input type="hidden" name="payment_date" value="{{ date('Y-m-d') }}">
                                <button type="submit" class="btn btn-sm btn-outline-success">Mark as Paid</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No salary records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($salaries->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $salaries->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
