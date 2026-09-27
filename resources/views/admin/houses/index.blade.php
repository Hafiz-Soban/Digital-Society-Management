@extends('layouts.admin')
@section('title', 'Houses')
@section('page-title', 'House Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Houses</h5>
        <p class="text-muted small mb-0">Manage all society houses and units</p>
    </div>
    <a href="{{ route('admin.houses.create') }}" class="btn btn-primary">
        <i class="bi bi-house-add me-2"></i>Add House
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by house number, block..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="block" class="form-select">
                    <option value="">All Blocks</option>
                    @foreach($blocks ?? [] as $block)
                        <option value="{{ $block }}" {{ request('block') == $block ? 'selected' : '' }}>Block {{ $block }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="is_rented" class="form-select">
                    <option value="">Rental Status</option>
                    <option value="yes" {{ request('is_rented') == 'yes' ? 'selected' : '' }}>Rented</option>
                    <option value="no" {{ request('is_rented') == 'no' ? 'selected' : '' }}>Not Rented</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="occupied" {{ request('status') == 'occupied' ? 'selected' : '' }}>Occupied</option>
                    <option value="vacant" {{ request('status') == 'vacant' ? 'selected' : '' }}>Vacant</option>
                    <option value="maintenance" {{ request('status') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.houses.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
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
                        <th>House No.</th>
                        <th>Block</th>
                        <th>Floor</th>
                        <th>Rented</th>
                        <th>Bedrooms</th>
                        <th>Area (sqft)</th>
<<<<<<< HEAD
=======
                        <th>Maintenance</th>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($houses as $house)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $house->house_number }}</div>
                        </td>
                        <td>{{ $house->block ?? '-' }}</td>
                        <td>{{ $house->floor ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $house->is_rented == 'yes' ? 'bg-warning' : 'bg-info' }}">
                                {{ ucfirst($house->is_rented) }}
                            </span>
                        </td>
                        <td>
                            <i class="bi bi-door-open text-muted me-1"></i>{{ $house->bedrooms ?? '-' }}
                        </td>
                        <td>{{ $house->area_sqft ? number_format($house->area_sqft) : '-' }}</td>
<<<<<<< HEAD
=======
                        <td>{{ $house->monthly_maintenance ? 'PKR ' . number_format($house->monthly_maintenance) : '-' }}</td>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <td>{!! $house->status_badge !!}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('admin.houses.show', $house) }}" class="btn btn-sm btn-outline-info" title="View">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.houses.edit', $house) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal{{ $house->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteModal{{ $house->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">Confirm Delete</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">Delete house <strong>{{ $house->house_number }}</strong>? This action cannot be undone.</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form method="POST" action="{{ route('admin.houses.destroy', $house) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="text-center py-5 text-muted">
                            <i class="bi bi-house fs-1 d-block mb-2"></i>
                            No houses found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($houses->hasMorePages())
=======
    @if($houses->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $houses->links() }}
    </div>
    @endif
</div>
@endsection
