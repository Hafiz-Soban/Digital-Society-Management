@extends('layouts.resident')
@section('title','Submit Complaint')
@section('page-title','Submit Complaint')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Submit a Complaint</h5>
        <p class="text-muted small mb-0">Describe your issue and we'll resolve it promptly</p>
    </div>
    <a href="{{ route('resident.complaints.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-chat-square-plus me-2 text-primary"></i>Complaint Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.complaints.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                                <option value="">— Select Category —</option>
                                @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id')==$cat->id?'selected':'' }}>
                                    {{ $cat->name }}
                                </option>
                                @endforeach
                            </select>
                            @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="">— Select Priority —</option>
                                <option value="low"    {{ old('priority')=='low'    ?'selected':'' }}>🟢 Low</option>
                                <option value="medium" {{ old('priority')=='medium' ?'selected':'' }}>🟡 Medium</option>
                                <option value="high"   {{ old('priority')=='high'   ?'selected':'' }}>🔴 High</option>
                                <option value="urgent" {{ old('priority')=='urgent' ?'selected':'' }}>🚨 Urgent</option>
                            </select>
                            @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Complaint Title <span class="text-danger">*</span></label>
                            <input type="text" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="Brief summary of the issue" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="5"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Describe the issue in detail (minimum 20 characters)…" required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">Attachment <span class="text-muted small">(optional)</span></label>
                            <input type="file" name="attachment"
                                   class="form-control @error('attachment') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.pdf,.doc,.docx">
                            <div class="form-text">Accepted: JPG, PNG, PDF, DOC · Max 5MB</div>
                            @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="alert alert-info mt-3 mb-0 d-flex gap-2" style="font-size:.82rem">
                        <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"></i>
                        <span>Your complaint will be reviewed by the management team. You'll receive notifications on status updates.</span>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('resident.complaints.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-send me-2"></i>Submit Complaint
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
