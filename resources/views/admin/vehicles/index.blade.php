@extends('layouts.admin')
@section('title', 'Vehicle List')
@section('page-title', 'Vehicle Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Registered Vehicles</h5>
        <p class="text-muted small mb-0">Total {{ $vehicles->total() }} vehicles registered in the society</p>
    </div>
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add Vehicle
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.vehicles.index') }}" class="row g-2">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search by number, sticker, house or owner..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2 ms-auto">
                <a href="{{ route('admin.vehicles.index') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Sticker #</th>
                        <th>Vehicle #</th>
                        <th>Owner / House</th>
                        <th>Type</th>
                        <th>Registration #</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($vehicles as $vehicle)
                    <tr>
                        <td><code class="fw-bold">{{ $vehicle->sticker_number }}</code></td>
                        <td><span class="fw-bold">{{ $vehicle->vehicle_number }}</span></td>
                        <td>
                            <div class="fw-semibold">{{ $vehicle->resident->user->name ?? 'N/A' }}</div>
                            <div class="small text-muted">House: {{ $vehicle->house->house_number ?? 'N/A' }}</div>
                        </td>
                        <td><span class="badge bg-info-subtle text-info">{{ ucfirst($vehicle->vehicle_type) }}</span></td>
                        <td>{{ $vehicle->registration_number }}</td>
                        <td>
                            @if($vehicle->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-sm btn-icon btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" onsubmit="return confirm('Are you sure you want to remove this vehicle?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-icon btn-outline-danger" title="Delete">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No vehicles found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($vehicles->hasMorePages())
    <div class="card-footer bg-white border-0">
        {{ $vehicles->links() }}
    </div>
    @endif
</div>
@endsection
