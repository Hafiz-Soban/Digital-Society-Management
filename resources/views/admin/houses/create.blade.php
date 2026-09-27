@extends('layouts.admin')
@section('title', 'Add House')
@section('page-title', 'Add New House')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Add New House</h5>
        <p class="text-muted small mb-0">Create a new house or unit in the society</p>
    </div>
    <a href="{{ route('admin.houses.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Houses
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-house me-2 text-primary"></i>House Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.houses.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row g-3">
                        <!-- House Number -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">House Number <span class="text-danger">*</span></label>
                            <input type="text" name="house_number" class="form-control @error('house_number') is-invalid @enderror"
                                value="{{ old('house_number') }}" placeholder="e.g. A-101" required>
                            @error('house_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Block -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Block</label>
                            <input type="text" name="block" class="form-control @error('block') is-invalid @enderror"
                                value="{{ old('block') }}" placeholder="e.g. A, B, C">
                            @error('block')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Floor -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Floor <span class="text-danger">*</span></label>
                            <select name="floor" class="form-select @error('floor') is-invalid @enderror" required>
                                <option value="">Select Floor</option>
                                <option value="Ground Floor" {{ old('floor') == 'Ground Floor' ? 'selected' : '' }}>Ground Floor</option>
                                <option value="First Floor" {{ old('floor') == 'First Floor' ? 'selected' : '' }}>First Floor</option>
                                <option value="Second Floor" {{ old('floor') == 'Second Floor' ? 'selected' : '' }}>Second Floor</option>
                            </select>
                            @error('floor')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Bedrooms -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Bedrooms <span class="text-danger">*</span></label>
                            <input type="number" name="bedrooms" class="form-control @error('bedrooms') is-invalid @enderror"
                                value="{{ old('bedrooms', 1) }}" placeholder="Number of bedrooms" min="1" required>
                            @error('bedrooms')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Area -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Area (sqft)</label>
                            <input type="number" name="area_sqft" class="form-control @error('area_sqft') is-invalid @enderror"
                                value="{{ old('area_sqft') }}" placeholder="e.g. 1200" min="0" step="0.01">
                            @error('area_sqft')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

<<<<<<< HEAD
=======
                        <!-- Monthly Maintenance -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Monthly Maintenance (PKR) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">PKR</span>
                                <input type="number" name="monthly_maintenance" class="form-control @error('monthly_maintenance') is-invalid @enderror"
                                    value="{{ old('monthly_maintenance', 0) }}" placeholder="e.g. 5000" min="0" step="0.01" required>
                                @error('monthly_maintenance')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description</label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="3" placeholder="Additional notes or description about this house...">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <h6 class="mb-3 fw-bold text-primary"><i class="bi bi-person-check-fill me-2"></i>Owner Information (Required for Registration)</h6>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Owner Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="owner_name" class="form-control @error('owner_name') is-invalid @enderror"
                                value="{{ old('owner_name') }}" placeholder="As per CNIC" required>
                            @error('owner_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Owner CNIC Number <span class="text-danger">*</span></label>
                            <input type="text" name="owner_cnic" class="form-control @error('owner_cnic') is-invalid @enderror"
                                value="{{ old('owner_cnic') }}" placeholder="42101-1234567-1" required>
                            @error('owner_cnic')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Owner Mobile Number <span class="text-danger">*</span></label>
                            <input type="text" name="owner_phone" class="form-control @error('owner_phone') is-invalid @enderror"
                                value="{{ old('owner_phone') }}" placeholder="03XXXXXXXXX" required>
                            @error('owner_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Rental Status -->
                    <hr class="my-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Is this house rented? <span class="text-danger">*</span></label>
                            <select name="is_rented" id="is_rented" class="form-select @error('is_rented') is-invalid @enderror" required>
                                <option value="no" {{ old('is_rented', 'no') == 'no' ? 'selected' : '' }}>No</option>
                                <option value="yes" {{ old('is_rented') == 'yes' ? 'selected' : '' }}>Yes</option>
                            </select>
                            @error('is_rented')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tenant Information Section (Conditional) -->
                    <div id="tenant_section" style="display: {{ old('is_rented') == 'yes' ? 'block' : 'none' }};">
                        <hr class="my-4">
                        <h6 class="mb-3 fw-bold text-primary"><i class="bi bi-person-lines-fill me-2"></i>Tenant Information</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Tenant Name <span class="text-danger">*</span></label>
                                <input type="text" name="tenant_name" class="form-control @error('tenant_name') is-invalid @enderror"
                                    value="{{ old('tenant_name') }}">
                                @error('tenant_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Father Name <span class="text-danger">*</span></label>
                                <input type="text" name="tenant_father_name" class="form-control @error('tenant_father_name') is-invalid @enderror"
                                    value="{{ old('tenant_father_name') }}">
                                @error('tenant_father_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">CNIC Number <span class="text-danger">*</span></label>
                                <input type="text" name="tenant_cnic" class="form-control @error('tenant_cnic') is-invalid @enderror"
                                    value="{{ old('tenant_cnic') }}" placeholder="42101-1234567-1">
                                @error('tenant_cnic')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Contact Number <span class="text-danger">*</span></label>
                                <input type="text" name="tenant_contact" class="form-control @error('tenant_contact') is-invalid @enderror"
                                    value="{{ old('tenant_contact') }}">
                                @error('tenant_contact')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rent Agreement Status <span class="text-danger">*</span></label>
                                <select name="rent_agreement_status" class="form-select @error('rent_agreement_status') is-invalid @enderror">
                                    <option value="">Select Status</option>
                                    <option value="issued" {{ old('rent_agreement_status') == 'issued' ? 'selected' : '' }}>Issued</option>
                                    <option value="not_issued" {{ old('rent_agreement_status') == 'not_issued' ? 'selected' : '' }}>Not Issued</option>
                                </select>
                                @error('rent_agreement_status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Rent Agreement Picture</label>
                                <input type="file" name="rent_agreement_picture" class="form-control @error('rent_agreement_picture') is-invalid @enderror">
                                <small class="text-muted">Allowed: JPG, PNG, JPEG, PDF (Max 2MB)</small>
                                @error('rent_agreement_picture')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.houses.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Create House
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const isRentedSelect = document.getElementById('is_rented');
        const tenantSection = document.getElementById('tenant_section');
        const tenantInputs = tenantSection.querySelectorAll('input, select');

        function toggleTenantSection() {
            if (isRentedSelect.value === 'yes') {
                tenantSection.style.display = 'block';
                tenantInputs.forEach(input => {
                    if (input.name !== 'rent_agreement_picture') {
                        input.setAttribute('required', 'required');
                    }
                });
            } else {
                tenantSection.style.display = 'none';
                tenantInputs.forEach(input => {
                    input.removeAttribute('required');
                });
            }
        }

        isRentedSelect.addEventListener('change', toggleTenantSection);
        
        // Run once on load to handle old input
        toggleTenantSection();
    });
</script>
@endpush
@endsection
