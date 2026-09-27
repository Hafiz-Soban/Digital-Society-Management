@extends('layouts.security')
@section('title', 'Add Visitor Entry')
@section('page-title', 'New Visitor Entry')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-person-plus me-2 text-danger"></i>Record New Visitor Entry</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.visitors.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-bold small">Select Resident / House <span class="text-danger">*</span></label>
                            <select name="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                <option value="">-- Choose Resident --</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}" {{ old('resident_id') == $resident->id ? 'selected' : '' }}>
                                        {{ $resident->user->name }} (House: {{ $resident->house->house_number ?? 'N/A' }}, Block: {{ $resident->house->block ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('resident_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Visitor Name <span class="text-danger">*</span></label>
                            <input type="text" name="visitor_name" class="form-control @error('visitor_name') is-invalid @enderror" value="{{ old('visitor_name') }}" required>
                            @error('visitor_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Visitor CNIC</label>
                            <input type="text" name="visitor_cnic" class="form-control @error('visitor_cnic') is-invalid @enderror" value="{{ old('visitor_cnic') }}" placeholder="42101-XXXXXXX-X">
                            @error('visitor_cnic') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Phone Number</label>
                            <input type="text" name="visitor_phone" class="form-control @error('visitor_phone') is-invalid @enderror" value="{{ old('visitor_phone') }}">
                            @error('visitor_phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small">Vehicle Number (if any)</label>
                            <input type="text" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" value="{{ old('vehicle_number') }}" placeholder="ABC-123">
                            @error('vehicle_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small">Purpose of Visit <span class="text-danger">*</span></label>
                            <input type="text" name="purpose" class="form-control @error('purpose') is-invalid @enderror" value="{{ old('purpose') }}" required placeholder="e.g. Delivery, Guest, Maintenance">
                            @error('purpose') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 mt-4">
                            <div class="alert alert-info py-2">
                                <small><i class="bi bi-info-circle me-2"></i>Note: Submitting this form will automatically mark the visitor as <strong>Checked In</strong> at the current time.</small>
                            </div>
                        </div>

                        <div class="col-12 text-end">
                            <a href="{{ route('security.visitors.index') }}" class="btn btn-light px-4">Cancel</a>
                            <button type="submit" class="btn btn-danger px-4">Record Entry</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
