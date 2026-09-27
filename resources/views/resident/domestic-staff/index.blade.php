@extends('layouts.resident')
@section('title','Domestic Staff')
@section('page-title','Domestic Staff Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Domestic Staff</h5>
        <p class="text-muted small mb-0">Add, manage, and track your household staff</p>
    </div>
    <a href="{{ route('resident.domestic-staff.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add Staff
    </a>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-primary">{{ $stats['total'] ?? 0 }}</div>
            <div class="text-muted small">Total</div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-success">{{ $stats['active'] ?? 0 }}</div>
            <div class="text-muted small">Active</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="card p-3 text-center">
            <div class="fw-bold fs-4 text-secondary">{{ $stats['inactive'] ?? 0 }}</div>
            <div class="text-muted small">Inactive</div>
        </div>
    </div>
</div>

<div class="card mb-4">
    <div class="card-body py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search text-muted"></i></span>
                    <input type="text" name="search" class="form-control border-start-0"
                           placeholder="Search by name, mobile, CNIC…" value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="staff_type" class="form-select">
                    <option value="">All Types</option>
                    @foreach($staffTypes as $key => $label)
                        <option value="{{ $key }}" {{ request('staff_type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Go</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('resident.domestic-staff.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Staff</th>
                        <th>Type</th>
                        <th>Mobile</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staff as $member)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="rounded-circle border bg-light" style="width:36px;height:36px;overflow:hidden;flex-shrink:0">
                                        @if($member->profile_photo_path)
                                            <img src="{{ asset('storage/' . $member->profile_photo_path) }}" alt="Photo" style="width:100%;height:100%;object-fit:cover">
                                        @else
                                            <div class="h-100 w-100 d-flex align-items-center justify-content-center text-muted">
                                                <i class="bi bi-person"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $member->name }}</div>
                                        <div class="text-muted small">{{ $member->cnic ?? '—' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>{{ $staffTypes[$member->staff_type] ?? ucfirst(str_replace('_',' ',$member->staff_type)) }}</td>
                            <td>{{ $member->mobile ?? '—' }}</td>
                            <td>{!! $member->status_badge !!}</td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="{{ route('resident.domestic-staff.show', $member->id) }}"
                                       class="btn btn-sm btn-outline-info" title="View">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('resident.domestic-staff.edit', $member->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('resident.domestic-staff.destroy', $member->id) }}"
                                          onsubmit="return confirm('Delete this staff member?')">
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
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="bi bi-people d-block fs-1 mb-2"></i>
                                No staff members found.
                                <div class="mt-2">
                                    <a href="{{ route('resident.domestic-staff.create') }}" class="btn btn-sm btn-primary">
                                        Add Your First Staff Member
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($staff->hasPages())
        <div class="card-footer bg-white">{{ $staff->links() }}</div>
    @endif
</div>
@endsection

