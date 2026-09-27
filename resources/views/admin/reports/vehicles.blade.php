@extends('layouts.admin')
@section('title', 'Vehicle Report')
@section('page-title', 'Analytics & Reports')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-primary text-white">
            <div class="card-body">
                <h6 class="text-white-50 small mb-1">Total Vehicles</h6>
                <h3 class="mb-0">{{ number_format($stats['total']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-success text-white">
            <div class="card-body">
                <h6 class="text-white-50 small mb-1">Active Vehicles</h6>
                <h3 class="mb-0">{{ number_format($stats['active']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-info text-white">
            <div class="card-body">
                <h6 class="text-white-50 small mb-1">Total Cars</h6>
                <h3 class="mb-0">{{ number_format($stats['cars']) }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm bg-warning text-dark">
            <div class="card-body">
                <h6 class="text-dark-50 small mb-1">Total Bikes</h6>
                <h3 class="mb-0">{{ number_format($stats['bikes']) }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold">Vehicle Type</label>
                <select name="type" class="form-select form-select-sm">
                    <option value="">All Types</option>
                    <option value="car" {{ request('type') == 'car' ? 'selected' : '' }}>Car</option>
                    <option value="bike" {{ request('type') == 'bike' ? 'selected' : '' }}>Bike</option>
                    <option value="suv" {{ request('type') == 'suv' ? 'selected' : '' }}>SUV</option>
                    <option value="van" {{ request('type') == 'van' ? 'selected' : '' }}>Van</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold">Status</label>
                <select name="status" class="form-select form-select-sm">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.reports.vehicles') }}" class="btn btn-sm btn-outline-secondary w-100">Reset</a>
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
                        <th>Owner</th>
                        <th>House</th>
                        <th>Type</th>
                        <th>Registration #</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($vehicles as $vehicle)
                    <tr>
                        <td><code>{{ $vehicle->sticker_number }}</code></td>
                        <td><span class="fw-bold">{{ $vehicle->vehicle_number }}</span></td>
                        <td>{{ $vehicle->resident->user->name ?? 'N/A' }}</td>
                        <td>{{ $vehicle->house->house_number ?? 'N/A' }}</td>
                        <td>{{ ucfirst($vehicle->vehicle_type) }}</td>
                        <td>{{ $vehicle->registration_number }}</td>
                        <td>
                            <span class="badge bg-{{ $vehicle->status == 'active' ? 'success' : 'danger' }}">
                                {{ ucfirst($vehicle->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
