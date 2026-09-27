@extends('layouts.resident')
@section('title','My House')
@section('page-title','My House')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">My House</h5>
    <p class="text-muted small mb-0">Details about your assigned residence</p>
</div>

<div class="row g-4">
    {{-- House Details --}}
    <div class="col-md-5">
        <div class="card">
            <div class="card-body p-0">
                <div class="p-4 text-center"
                     style="background:linear-gradient(135deg,#0f4c81,#1a6bb5);border-radius:12px 12px 0 0">
                    <div class="bg-white bg-opacity-20 rounded-3 d-inline-flex align-items-center justify-content-center mb-3"
                         style="width:70px;height:70px">
                        <i class="bi bi-house-fill text-white fs-1"></i>
                    </div>
                    <h3 class="text-white fw-bold mb-1">{{ $house->house_number }}</h3>
                    <div>{!! $house->status_badge !!}</div>
                </div>
                <div class="p-4">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-grid me-2"></i>Block</span>
                            <span class="fw-semibold">{{ $house->block ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-layers me-2"></i>Floor</span>
                            <span class="fw-semibold">{{ $house->floor ?? '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
<<<<<<< HEAD
                            <span class="text-muted"><i class="bi bi-building me-2"></i>Is Rented</span>
                            <span class="badge {{ $house->is_rented == 'yes' ? 'bg-success' : 'bg-secondary' }}">{{ $house->is_rented == 'yes' ? 'Yes' : 'No' }}</span>
=======
                            <span class="text-muted"><i class="bi bi-building me-2"></i>Type</span>
                            <span class="badge bg-secondary">{{ ucfirst($house->type) }}</span>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-door-open me-2"></i>Bedrooms</span>
                            <span class="fw-semibold">{{ $house->bedrooms }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-aspect-ratio me-2"></i>Area</span>
                            <span class="fw-semibold">{{ $house->area_sqft ? number_format($house->area_sqft).' sqft' : '—' }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-cash me-2"></i>Monthly Maintenance</span>
                            <span class="fw-bold text-primary">PKR {{ number_format($house->monthly_maintenance) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-key me-2"></i>Ownership</span>
                            <span class="badge {{ $resident->ownership_type==='owner'?'bg-success':'bg-info' }}">
                                {{ ucfirst($resident->ownership_type) }}
                            </span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted"><i class="bi bi-calendar-check me-2"></i>Move-in Date</span>
                            <span class="fw-semibold">{{ $resident->move_in_date?->format('d M Y') ?? '—' }}</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column --}}
    <div class="col-md-7">
        {{-- Description --}}
        @if($house->description)
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-info-circle me-2 text-info"></i>Description</h6>
            </div>
            <div class="card-body">
                <p class="mb-0 text-muted">{{ $house->description }}</p>
            </div>
        </div>
        @endif

        {{-- Quick Stats --}}
        <div class="row g-3 mb-4">
            <div class="col-6">
                <div class="card p-3 text-center">
                    <div class="fw-bold fs-4 text-warning">{{ $resident->maintenanceRequests()->count() }}</div>
                    <div class="text-muted small">Maintenance Requests</div>
                </div>
            </div>
            <div class="col-6">
                <div class="card p-3 text-center">
                    <div class="fw-bold fs-4 text-primary">{{ $resident->complaints()->count() }}</div>
                    <div class="text-muted small">Complaints Filed</div>
                </div>
            </div>
        </div>

        {{-- Maintenance History --}}
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-tools me-2 text-warning"></i>Maintenance History</h6>
                <a href="{{ route('resident.maintenance.index') }}" class="btn btn-sm btn-outline-warning">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr><th>Request #</th><th>Title</th><th>Category</th><th>Status</th></tr>
                        </thead>
                        <tbody>
                            @forelse($maintenanceHistory as $m)
                            <tr>
                                <td><a href="{{ route('resident.maintenance.show',$m) }}"
                                       class="text-decoration-none fw-semibold text-warning">{{ $m->request_number }}</a></td>
                                <td>{{ Str::limit($m->title,30) }}</td>
                                <td><span class="badge bg-light text-dark border">{{ ucfirst($m->category) }}</span></td>
                                <td>{!! $m->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No maintenance history</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
