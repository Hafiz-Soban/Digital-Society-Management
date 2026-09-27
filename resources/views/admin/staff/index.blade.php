@extends('layouts.admin')

<<<<<<< HEAD
@section('title', 'Staff List')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Staff Management</h2>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Add Staff
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.staff.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control border-start-0" placeholder="Search by name, ID or phone..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <input type="text" name="designation" class="form-control" placeholder="Filter by designation..." value="{{ request('designation') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>
                <div class="col-md-2">
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
                        <th>Photo</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Designation</th>
                        <th>Joining Date</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
=======
@section('title', 'Society Staff')
@section('page-title', 'Society Staff')

@section('content')
<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold">Staff Directory</h5>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-person-plus-fill me-1"></i> Add Staff Member
        </a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Staff Details</th>
                        <th>Contact Info</th>
                        <th>Designation</th>
                        <th>Salary</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffMembers as $staff)
<<<<<<< HEAD
                    <tr>
                        <td>
                            @if($staff->photo_path)
                                <img src="{{ asset('storage/' . $staff->photo_path) }}" class="rounded-circle" width="40" height="40" alt="">
                            @else
                                <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                    <i class="bi bi-person text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td><span class="fw-bold">{{ $staff->employee_id }}</span></td>
                        <td>{{ $staff->full_name }}</td>
                        <td>{{ $staff->phone_number }}</td>
                        <td><span class="badge bg-info-subtle text-info">{{ $staff->designation }}</span></td>
                        <td>{{ $staff->joining_date->format('d M, Y') }}</td>
                        <td>Rs. {{ number_format($staff->salary, 2) }}</td>
                        <td>
                            @if($staff->status == 'active')
                                <span class="badge bg-success-subtle text-success">Active</span>
                            @else
                                <span class="badge bg-danger-subtle text-danger">Inactive</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-sm btn-outline-primary" title="View Profile">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-sm btn-outline-dark" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this staff member?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">No staff members found.</td>
                    </tr>
=======
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-circle bg-primary-subtle text-primary fw-bold">
                                        {{ strtoupper(substr($staff->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold text-main">{{ $staff->name }}</div>
                                        <div class="small text-muted">Joined: {{ $staff->joining_date->format('M d, Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small"><i class="bi bi-envelope me-1"></i> {{ $staff->email }}</div>
                                <div class="small"><i class="bi bi-telephone me-1"></i> {{ $staff->phone }}</div>
                            </td>
                            <td><span class="text-main fw-medium">{{ $staff->designation }}</span></td>
                            <td><span class="fw-bold text-success">Rs. {{ number_format($staff->salary, 2) }}</span></td>
                            <td>{!! $staff->status_badge !!}</td>
                            <td class="text-end pe-4">
                                <div class="btn-group">
                                    <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.staff.destroy', $staff) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this staff member?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-people fs-1 d-block mb-3 opacity-25"></i>
                                    No staff members found.
                                </div>
                            </td>
                        </tr>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    @endforelse
                </tbody>
            </table>
        </div>
<<<<<<< HEAD
        @if($staffMembers->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $staffMembers->links() }}
        </div>
        @endif
    </div>
</div>
=======
    </div>
    @if($staffMembers->hasPages())
        <div class="card-footer bg-white py-3">
            {{ $staffMembers->links() }}
        </div>
    @endif
</div>

<style>
    .avatar-circle {
        width: 40px; height: 40px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
    }
</style>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
@endsection
