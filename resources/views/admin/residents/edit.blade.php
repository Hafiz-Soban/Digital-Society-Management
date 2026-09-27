@extends('layouts.admin')
@section('title', 'Edit Resident')
@section('page-title', 'Edit Resident')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Edit Resident: {{ $resident->user->name }}</h5>
        <p class="text-muted small mb-0">ID: <code>{{ $resident->resident_id }}</code></p>
    </div>
    <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<form method="POST" action="{{ route('admin.residents.update', $resident) }}">
    @csrf @method('PUT')
    <div class="row g-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">Account Information</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" value="{{ old('name', $resident->user->name) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="{{ old('email', $resident->user->email) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Phone Number</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $resident->user->phone) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-select" required>
                            <option value="active" {{ old('status', $resident->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $resident->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="moved_out" {{ old('status', $resident->status) == 'moved_out' ? 'selected' : '' }}>Moved Out</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">Resident Details</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Assign House</label>
                        <select name="house_id" class="form-select">
                            <option value="">-- No House --</option>
                            @foreach($houses as $house)
                                <option value="{{ $house->id }}" {{ old('house_id', $resident->house_id) == $house->id ? 'selected' : '' }}>
                                    {{ $house->house_number }} ({{ ucfirst($house->status) }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">CNIC</label>
                        <input type="text" name="cnic" class="form-control" value="{{ old('cnic', $resident->cnic) }}">
                    </div>
                    <div class="row">
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Ownership Type</label>
                            <select name="ownership_type" class="form-select" required>
                                <option value="tenant" {{ old('ownership_type', $resident->ownership_type) == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="owner" {{ old('ownership_type', $resident->ownership_type) == 'owner' ? 'selected' : '' }}>Owner</option>
                            </select>
                        </div>
                        <div class="col-6 mb-3">
                            <label class="form-label fw-semibold">Family Members</label>
                            <input type="number" name="family_members" class="form-control" value="{{ old('family_members', $resident->family_members) }}" min="1" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Move In Date</label>
                        <input type="date" name="move_in_date" class="form-control" value="{{ old('move_in_date', $resident->move_in_date?->format('Y-m-d')) }}">
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold">Emergency Contact</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name', $resident->emergency_contact_name) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Contact Phone</label>
                            <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone', $resident->emergency_contact_phone) }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Relation</label>
                            <input type="text" name="emergency_contact_relation" class="form-control" value="{{ old('emergency_contact_relation', $resident->emergency_contact_relation) }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-2"></i>Update Resident
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
