@extends('layouts.admin')

@section('title', 'Salary Report')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="h4">Salary Report</h2>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.salaries') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Month</label>
                    <input type="text" name="month" class="form-control" placeholder="e.g. June 2026" value="{{ request('month') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Staff Name</th>
                        <th>Month</th>
                        <th>Amount</th>
                        <th>Payment Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($salaries as $sal)
                    <tr>
                        <td>{{ $sal->staff->full_name }}</td>
                        <td>{{ $sal->month }}</td>
                        <td>Rs. {{ number_format($sal->amount, 2) }}</td>
                        <td>{{ $sal->payment_date ? $sal->payment_date->format('d M, Y') : '-' }}</td>
                        <td>{{ ucfirst($sal->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
