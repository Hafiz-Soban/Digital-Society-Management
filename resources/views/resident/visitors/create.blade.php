@extends('layouts.resident')
@section('title','Add Visitor')
@section('page-title','Add Visitor Request')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Add Visitor Request</h5>
        <p class="text-muted small mb-0">Register an expected visitor for your house</p>
    </div>
    <a href="{{ route('resident.visitors.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-plus me-2 text-primary"></i>Visitor Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.visitors.store') }}">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Visitor Name <span class="text-danger">*</span></label>
                            <input type="text" name="visitor_name"
                                   class="form-control @error('visitor_name') is-invalid @enderror"
                                   value="{{ old('visitor_name') }}" placeholder="Full name" required>
                            @error('visitor_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="visitor_phone"
                                   class="form-control @error('visitor_phone') is-invalid @enderror"
                                   value="{{ old('visitor_phone') }}" placeholder="+92 300 0000000">
                            @error('visitor_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">CNIC / ID</label>
                            <input type="text" name="visitor_cnic"
                                   class="form-control @error('visitor_cnic') is-invalid @enderror"
                                   value="{{ old('visitor_cnic') }}" placeholder="42101-1234567-1">
                            @error('visitor_cnic')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Vehicle Number</label>
                            <input type="text" name="vehicle_number"
                                   class="form-control @error('vehicle_number') is-invalid @enderror"
                                   value="{{ old('vehicle_number') }}" placeholder="ABC-123">
                            @error('vehicle_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Purpose of Visit <span class="text-danger">*</span></label>
                            <input type="text" name="purpose"
                                   class="form-control @error('purpose') is-invalid @enderror"
                                   value="{{ old('purpose') }}" placeholder="e.g. Family visit, Delivery, Meeting" required>
                            @error('purpose')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Expected Arrival</label>
                            <input type="datetime-local" name="expected_arrival"
                                   class="form-control @error('expected_arrival') is-invalid @enderror"
                                   value="{{ old('expected_arrival') }}">
                            @error('expected_arrival')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="notes" rows="3"
                                      class="form-control @error('notes') is-invalid @enderror"
                                      placeholder="Any additional notes for security…">{{ old('notes') }}</textarea>
                            @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0 d-flex gap-2" style="font-size:.82rem">
                        <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"></i>
                        <span>Your visitor will be automatically approved. Security will verify their identity at the gate.</span>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('resident.visitors.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-person-plus me-2"></i>Add Visitor
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
