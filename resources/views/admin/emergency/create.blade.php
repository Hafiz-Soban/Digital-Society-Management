@extends('layouts.admin')
@section('title', 'Create Emergency Alert')
@section('page-title', 'Create Emergency Alert')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Create Emergency Alert</h5>
        <p class="text-muted small mb-0">Issue an emergency alert to all residents and security</p>
    </div>
    <a href="{{ route('admin.emergency.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Alerts
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="alert alert-warning d-flex gap-2 mb-4">
            <i class="bi bi-exclamation-triangle-fill fs-5 flex-shrink-0 mt-1"></i>
            <div>
                <strong>Warning:</strong> Emergency alerts are immediately broadcast to all residents and security personnel. Use only for genuine emergencies.
            </div>
        </div>

        <div class="card border-danger">
            <div class="card-header bg-danger text-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-exclamation-triangle me-2"></i>Emergency Alert Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.emergency.store') }}">
                    @csrf

                    <div class="row g-3">
                        <!-- Title -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Alert Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
                                value="{{ old('title') }}" placeholder="e.g. Fire in Block A, Water Supply Disruption..." required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Alert Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="fire" {{ old('type') == 'fire' ? 'selected' : '' }}>Fire</option>
                                <option value="flood" {{ old('type') == 'flood' ? 'selected' : '' }}>Flood</option>
                                <option value="medical" {{ old('type') == 'medical' ? 'selected' : '' }}>Medical Emergency</option>
                                <option value="security" {{ old('type') == 'security' ? 'selected' : '' }}>Security Threat</option>
                                <option value="power" {{ old('type') == 'power' ? 'selected' : '' }}>Power Outage</option>
                                <option value="gas" {{ old('type') == 'gas' ? 'selected' : '' }}>Gas Leak</option>
                                <option value="structural" {{ old('type') == 'structural' ? 'selected' : '' }}>Structural Damage</option>
                                <option value="other" {{ old('type') == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Severity -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Severity <span class="text-danger">*</span></label>
                            <select name="severity" class="form-select @error('severity') is-invalid @enderror" required>
                                <option value="">Select Severity</option>
                                <option value="low" {{ old('severity') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="medium" {{ old('severity') == 'medium' ? 'selected' : '' }}>Medium</option>
                                <option value="high" {{ old('severity') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="critical" {{ old('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                            </select>
                            @error('severity')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Location -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Location / Area Affected</label>
                            <input type="text" name="location" class="form-control @error('location') is-invalid @enderror"
                                value="{{ old('location') }}" placeholder="e.g. Block A, Floor 3, Main Gate...">
                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" class="form-control @error('description') is-invalid @enderror"
                                rows="4" placeholder="Describe the emergency situation in detail..." required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Instructions -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Instructions for Residents</label>
                            <textarea name="instructions" class="form-control @error('instructions') is-invalid @enderror"
                                rows="3" placeholder="What should residents do? e.g. Evacuate immediately, Stay indoors...">{{ old('instructions') }}</textarea>
                            @error('instructions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.emergency.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-exclamation-triangle me-2"></i>Issue Emergency Alert
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
