@extends('layouts.security')
@section('title', 'Report Incident')
@section('page-title', 'Report New Incident')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-shield-plus me-2 text-danger"></i>Report Security Incident</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('security.incidents.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-4">
                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Incident Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror" 
                                   placeholder="Brief summary of the incident" value="{{ old('title') }}" required>
                            @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Incident Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">-- Select Type --</option>
                                <option value="theft" {{ old('type') == 'theft' ? 'selected' : '' }}>Theft</option>
                                <option value="property_damage" {{ old('type') == 'property_damage' ? 'selected' : '' }}>Property Damage</option>
                                <option value="unauthorized_access" {{ old('type') == 'unauthorized_access' ? 'selected' : '' }}>Unauthorized Access</option>
                                <option value="security_violation" {{ old('type') == 'security_violation' ? 'selected' : '' }}>Security Violation</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-muted">Location <span class="text-danger">*</span></label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror" 
                                   placeholder="e.g. Block A, Main Gate, Park" value="{{ old('location') }}" required>
                            @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Detailed Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror" 
                                      rows="5" placeholder="Provide as much detail as possible..." required>{{ old('description') }}</textarea>
                            @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-muted">Attach Image (Optional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-camera"></i></span>
                                <input type="file" name="image" class="form-control @error('image') is-invalid @enderror" accept="image/*">
                            </div>
                            <div class="form-text small">Max size: 2MB. Format: JPG, PNG.</div>
                            @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12 text-end mt-5 pt-3 border-top">
                            <a href="{{ route('security.incidents.index') }}" class="btn btn-light px-4 me-2">Cancel</a>
                            <button type="submit" class="btn btn-danger px-4 fw-bold">Submit Incident Report</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
