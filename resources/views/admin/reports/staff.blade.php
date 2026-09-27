@extends('layouts.admin')

@section('title', 'Staff Report')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="h4">Staff Report</h2>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.reports.staff') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">Designation</label>
                    <input type="text" name="designation" class="form-control" placeholder="Search designation..." value="{{ request('designation') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Generate Report</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Phone</th>
                        <th>Salary</th>
                        <th>Joining Date</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($staffMembers as $staff)
                    <tr>
                        <td>{{ $staff->employee_id }}</td>
                        <td>{{ $staff->full_name }}</td>
                        <td>{{ $staff->designation }}</td>
                        <td>{{ $staff->phone_number }}</td>
                        <td>Rs. {{ number_format($staff->salary, 2) }}</td>
                        <td>{{ $staff->joining_date->format('d M, Y') }}</td>
                        <td>{{ ucfirst($staff->status) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
