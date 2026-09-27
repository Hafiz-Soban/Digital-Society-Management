@extends('layouts.admin')
@section('title', 'House Details')
@section('page-title', 'House Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">House — {{ $house->house_number }}</h5>
        <p class="text-muted small mb-0">Full details, resident info and maintenance history</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.houses.edit', $house) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
        <a href="{{ route('admin.houses.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- House Info -->
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-house me-2 text-primary"></i>House Information</h6>
            </div>
            <div class="card-body">
                <div class="text-center mb-4">
                    <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:80px;height:80px">
                        <i class="bi bi-house-fill text-primary fs-1"></i>
                    </div>
                    <h4 class="fw-bold mb-1">{{ $house->house_number }}</h4>
                    <div>{!! $house->status_badge !!}</div>
                </div>

                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Block</span>
                        <span class="fw-semibold">{{ $house->block ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Floor</span>
                        <span class="fw-semibold">{{ $house->floor ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Rented</span>
                        <span class="badge {{ $house->is_rented == 'yes' ? 'bg-warning' : 'bg-info' }}">
                            {{ ucfirst($house->is_rented) }}
                        </span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Bedrooms</span>
                        <span class="fw-semibold">{{ $house->bedrooms ?? '-' }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Area</span>
                        <span class="fw-semibold">{{ $house->area_sqft ? number_format($house->area_sqft) . ' sqft' : '-' }}</span>
                    </li>
<<<<<<< HEAD
=======
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted small">Monthly Maintenance</span>
                        <span class="fw-semibold">{{ $house->monthly_maintenance ? 'PKR ' . number_format($house->monthly_maintenance) : '-' }}</span>
                    </li>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                </ul>

                @if($house->description)
                <div class="mt-3">
                    <p class="text-muted small mb-1">Description</p>
                    <p class="small mb-0">{{ $house->description }}</p>
                </div>
                @endif
            </div>
        </div>

        @if($house->is_rented == 'yes')
        <!-- Tenant Info -->
        <div class="card mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-lines-fill me-2 text-info"></i>Tenant Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <div class="text-muted small">Tenant Name</div>
                        <div class="fw-semibold">{{ $house->tenant_name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Father Name</div>
                        <div class="fw-semibold">{{ $house->tenant_father_name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">CNIC Number</div>
                        <div class="fw-semibold">{{ $house->tenant_cnic }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Contact Number</div>
                        <div class="fw-semibold">{{ $house->tenant_contact }}</div>
                    </div>
                    <div class="col-sm-6">
                        <div class="text-muted small">Agreement Status</div>
                        <span class="badge {{ $house->rent_agreement_status == 'issued' ? 'bg-success' : 'bg-danger' }}">
                            {{ ucfirst(str_replace('_', ' ', $house->rent_agreement_status)) }}
                        </span>
                    </div>
                    @if($house->rent_agreement_path)
                    <div class="col-sm-6">
                        <div class="text-muted small">Agreement Document</div>
                        <a href="{{ Storage::url($house->rent_agreement_path) }}" target="_blank" class="btn btn-sm btn-link p-0 text-decoration-none">
                            <i class="bi bi-file-earmark-text me-1"></i>View Agreement
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    <!-- Current Resident -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-success"></i>Current Resident</h6>
            </div>
            <div class="card-body">
                @if($house->currentResident)
                    @php $resident = $house->currentResident; @endphp
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <img src="{{ $resident->user->avatar_url }}" class="rounded-circle" width="60" height="60" alt="">
                        <div>
                            <h6 class="fw-bold mb-1">{{ $resident->user->name }}</h6>
                            <div class="text-muted small">{{ $resident->user->email }}</div>
                            <div class="text-muted small">{{ $resident->user->phone ?? 'No phone' }}</div>
                        </div>
                        <div class="ms-auto">
                            {!! $resident->status_badge !!}
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <div class="text-muted small">Resident ID</div>
                                <code class="fw-semibold">{{ $resident->resident_id }}</code>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <div class="text-muted small">Ownership</div>
                                <div class="fw-semibold">{{ ucfirst($resident->ownership_type) }}</div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="bg-light rounded-3 p-3 text-center">
                                <div class="text-muted small">Move-in Date</div>
                                <div class="fw-semibold">{{ $resident->move_in_date?->format('d M Y') ?? '-' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.residents.show', $resident) }}" class="btn btn-sm btn-outline-primary">
                            <i class="bi bi-person me-1"></i>View Resident Profile
                        </a>
                    </div>
                @else
                    <div class="text-center py-4 text-muted">
                        <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                        <p class="mb-0">No current resident assigned to this house</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Maintenance History -->
<<<<<<< HEAD
        <div class="card mb-4">
=======
        <div class="card">
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-tools me-2 text-warning"></i>Maintenance History</h6>
                <span class="badge bg-secondary">{{ $maintenanceRequests->total() ?? 0 }} requests</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Request #</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($maintenanceRequests ?? [] as $request)
                            <tr>
                                <td><code>{{ $request->request_number }}</code></td>
                                <td>
                                    <a href="{{ route('admin.maintenance.show', $request) }}" class="text-decoration-none">
                                        {{ Str::limit($request->title, 40) }}
                                    </a>
                                </td>
                                <td>{{ $request->category ?? '-' }}</td>
                                <td>{!! $request->priority_badge !!}</td>
                                <td>{!! $request->status_badge !!}</td>
                                <td>{{ $request->created_at->format('d M Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-4 text-muted">
                                    <i class="bi bi-tools fs-3 d-block mb-1"></i>
                                    No maintenance history
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
<<<<<<< HEAD
            @if(isset($maintenanceRequests) && $maintenanceRequests->hasMorePages())
=======
            @if(isset($maintenanceRequests) && $maintenanceRequests->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            <div class="card-footer bg-white">
                {{ $maintenanceRequests->links() }}
            </div>
            @endif
        </div>
<<<<<<< HEAD

        <!-- Registered Vehicles -->
        <div class="card">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-car-front-fill me-2 text-info"></i>Registered Vehicles</h6>
                <span class="badge bg-info">{{ $house->vehicles->count() }} vehicles</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle #</th>
                                <th>Sticker #</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($house->vehicles as $vehicle)
                            <tr>
                                <td><span class="fw-bold">{{ $vehicle->vehicle_number }}</span></td>
                                <td><code>{{ $vehicle->sticker_number }}</code></td>
                                <td>{{ ucfirst($vehicle->vehicle_type) }}</td>
                                <td>
                                    @if($vehicle->status == 'active')
                                        <span class="badge bg-success">Active</span>
                                    @else
                                        <span class="badge bg-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-muted">
                                    <i class="bi bi-car-front fs-3 d-block mb-1"></i>
                                    No registered vehicles for this house
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    </div>
</div>
@endsection
