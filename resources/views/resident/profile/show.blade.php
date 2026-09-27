@extends('layouts.resident')
@section('title','My Profile')
@section('page-title','My Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">My Profile</h5>
        <p class="text-muted small mb-0">View and manage your personal information</p>
    </div>
    <a href="{{ route('resident.profile.edit') }}" class="btn btn-primary">
        <i class="bi bi-pencil me-2"></i>Edit Profile
    </a>
</div>

<div class="row g-4">
    {{-- Profile Card --}}
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <img src="{{ $user->avatar_url }}" class="rounded-circle border border-3 border-primary"
                     width="100" height="100" alt="Avatar" style="object-fit:cover">
                <a href="{{ route('resident.profile.edit') }}"
                   class="position-absolute bottom-0 end-0 btn btn-sm btn-primary rounded-circle p-1"
                   style="width:28px;height:28px;display:flex;align-items:center;justify-content:center">
                    <i class="bi bi-camera" style="font-size:.7rem"></i>
                </a>
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-2">{{ $user->email }}</p>
            <div class="mb-3">
                <span class="badge bg-primary">Resident</span>
                @if($resident)
                    <span class="badge {{ $resident->ownership_type==='owner'?'bg-success':'bg-info' }} ms-1">
                        {{ ucfirst($resident->ownership_type) }}
                    </span>
                @endif
            </div>
            @if($resident)
            <div class="border-top pt-3">
                <div class="row text-center g-2">
                    <div class="col-4">
                        <div class="fw-bold text-primary">{{ $resident->complaints()->count() }}</div>
                        <div class="text-muted" style="font-size:.7rem">Complaints</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-warning">{{ $resident->maintenanceRequests()->count() }}</div>
                        <div class="text-muted" style="font-size:.7rem">Maintenance</div>
                    </div>
                    <div class="col-4">
                        <div class="fw-bold text-info">{{ $resident->visitors()->count() }}</div>
                        <div class="text-muted" style="font-size:.7rem">Visitors</div>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

    {{-- Details --}}
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-primary"></i>Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Full Name</label>
                        <div class="fw-semibold">{{ $user->name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Email</label>
                        <div class="fw-semibold">{{ $user->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Phone</label>
                        <div class="fw-semibold">{{ $user->phone ?? '—' }}</div>
                    </div>
                    @if($resident)
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Resident ID</label>
                        <div class="fw-semibold"><code>{{ $resident->resident_id }}</code></div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">CNIC</label>
                        <div class="fw-semibold">{{ $resident->cnic ?? '—' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Gender</label>
                        <div class="fw-semibold">{{ ucfirst($resident->gender ?? '—') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Date of Birth</label>
                        <div class="fw-semibold">{{ $resident->date_of_birth?->format('d M Y') ?? '—' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Family Members</label>
                        <div class="fw-semibold">{{ $resident->family_members }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Move-in Date</label>
                        <div class="fw-semibold">{{ $resident->move_in_date?->format('d M Y') ?? '—' }}</div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        @if($resident)
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-telephone-fill me-2 text-danger"></i>Emergency Contact</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-4">
                        <label class="text-muted small d-block">Name</label>
                        <div class="fw-semibold">{{ $resident->emergency_contact_name ?? '—' }}</div>
                    </div>
                    <div class="col-sm-4">
                        <label class="text-muted small d-block">Phone</label>
                        <div class="fw-semibold">{{ $resident->emergency_contact_phone ?? '—' }}</div>
                    </div>
                    <div class="col-sm-4">
                        <label class="text-muted small d-block">Relation</label>
                        <div class="fw-semibold">{{ $resident->emergency_contact_relation ?? '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        @if($resident->house)
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-house me-2 text-success"></i>House Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-3">
                        <label class="text-muted small d-block">House No.</label>
                        <div class="fw-bold text-primary">{{ $resident->house->house_number }}</div>
                    </div>
                    <div class="col-sm-3">
                        <label class="text-muted small d-block">Block</label>
                        <div class="fw-semibold">{{ $resident->house->block ?? '—' }}</div>
                    </div>
                    <div class="col-sm-3">
<<<<<<< HEAD
                        <label class="text-muted small d-block">Is Rented</label>
                        <div class="fw-semibold">{{ $resident->house->is_rented == 'yes' ? 'Yes' : 'No' }}</div>
=======
                        <label class="text-muted small d-block">Type</label>
                        <div class="fw-semibold">{{ ucfirst($resident->house->type) }}</div>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                    </div>
                    <div class="col-sm-3">
                        <label class="text-muted small d-block">Ownership</label>
                        <div class="fw-semibold">{{ ucfirst($resident->ownership_type) }}</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>
@endsection
