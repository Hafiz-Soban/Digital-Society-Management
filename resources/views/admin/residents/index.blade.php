@extends('layouts.admin')
@section('title', 'Residents')
@section('page-title', 'Resident Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Residents</h5>
        <p class="text-muted small mb-0">Manage all society residents</p>
    </div>
    <a href="{{ route('admin.residents.create') }}" class="btn btn-primary">
        <i class="bi bi-person-plus me-2"></i>Add Resident
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by name, email, phone, ID..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="moved_out" {{ request('status') == 'moved_out' ? 'selected' : '' }}>Moved Out</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                        <th>Resident</th>
                        <th>ID</th>
                        <th>House</th>
                        <th>Type</th>
                        <th>Phone</th>
                        <th>Move In</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $resident->user->avatar_url }}" class="rounded-circle" width="36" height="36" alt="">
                                <div>
                                    <div class="fw-semibold">{{ $resident->user->name }}</div>
                                    <div class="text-muted small">{{ $resident->user->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td><code>{{ $resident->resident_id }}</code></td>
                        <td>{{ $resident->house->house_number ?? '<span class="text-muted">Unassigned</span>' }}</td>
                        <td><span class="badge {{ $resident->ownership_type == 'owner' ? 'bg-primary' : 'bg-info' }}">{{ ucfirst($resident->ownership_type) }}</span></td>
                        <td>{{ $resident->user->phone ?? '-' }}</td>
                        <td>{{ $resident->move_in_date?->format('d M Y') ?? '-' }}</td>
                        <td>{!! $resident->status_badge !!}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.residents.show', $resident) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.residents.edit', $resident) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.residents.destroy', $resident) }}" onsubmit="return confirm('Delete this resident?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            No residents found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($residents->hasMorePages())
=======
    @if($residents->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $residents->links() }}
    </div>
    @endif
</div>
@endsection
