@extends('layouts.admin')
@section('title', 'Add Resident')
@section('page-title', 'Add New Resident')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Add New Resident</h5>
        <p class="text-muted small mb-0">Fill in the details to register a new resident</p>
    </div>
    <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<form method="POST" action="{{ route('admin.residents.store') }}">
    @csrf
    <div class="row g-4">
        <!-- Resident Details -->
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-person-badge me-2 text-primary"></i>Resident Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Assign House</label>
                            <select name="house_id" class="form-select">
                                <option value="">-- Select House --</option>
                                @foreach($houses as $house)
                                    <option value="{{ $house->id }}" {{ old('house_id') == $house->id ? 'selected' : '' }}>
                                        {{ $house->house_number }} ({{ $house->bedrooms }} BR)
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">CNIC</label>
                            <input type="text" name="cnic" class="form-control" value="{{ old('cnic') }}" placeholder="42101-1234567-1">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Date of Birth</label>
                            <input type="date" name="date_of_birth" class="form-control" value="{{ old('date_of_birth') }}">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Gender</label>
                            <select name="gender" class="form-select">
                                <option value="">Select</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Ownership Type <span class="text-danger">*</span></label>
                            <select name="ownership_type" class="form-select" required>
                                <option value="tenant" {{ old('ownership_type') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                                <option value="owner" {{ old('ownership_type') == 'owner' ? 'selected' : '' }}>Owner</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Family Members <span class="text-danger">*</span></label>
                            <input type="number" name="family_members" class="form-control" value="{{ old('family_members', 1) }}" min="1" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Move In Date</label>
                            <input type="date" name="move_in_date" class="form-control" value="{{ old('move_in_date') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Emergency Contact -->
        <div class="col-md-8 mx-auto">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-telephone-fill me-2 text-danger"></i>Emergency Contact</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Contact Name</label>
                            <input type="text" name="emergency_contact_name" class="form-control" value="{{ old('emergency_contact_name') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Contact Phone</label>
                            <input type="text" name="emergency_contact_phone" class="form-control" value="{{ old('emergency_contact_phone') }}">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Relation</label>
                            <input type="text" name="emergency_contact_relation" class="form-control" value="{{ old('emergency_contact_relation') }}" placeholder="Spouse, Parent, Sibling...">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-8 mx-auto">
            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('admin.residents.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-person-plus me-2"></i>Add Resident
                </button>
            </div>
        </div>
    </div>
</form>
@endsection
