@extends('layouts.resident')
@section('title','New Maintenance Request')
@section('page-title','Submit Maintenance Request')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Submit Maintenance Request</h5>
        <p class="text-muted small mb-0">
            House: <strong>{{ $resident->house->house_number ?? 'N/A' }}</strong>
        </p>
    </div>
    <a href="{{ route('resident.maintenance.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold">
                    <i class="bi bi-tools me-2 text-warning"></i>Request Details
                </h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.maintenance.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row g-3">

                        <div class="col-12">
                            <label class="form-label fw-semibold">Request Title <span class="text-danger">*</span></label>
                            <input type="text" name="title"
                                   class="form-control @error('title') is-invalid @enderror"
                                   value="{{ old('title') }}"
                                   placeholder="e.g. Leaking pipe in bathroom" required>
                            @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                            <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                <option value="">— Select Category —</option>
                                @foreach([
                                    'plumbing'    => '🔧 Plumbing',
                                    'electrical'  => '⚡ Electrical',
                                    'carpentry'   => '🪚 Carpentry',
                                    'painting'    => '🎨 Painting',
                                    'cleaning'    => '🧹 Cleaning',
                                    'other'       => '📋 Other',
                                ] as $val => $label)
                                <option value="{{ $val }}" {{ old('category')==$val?'selected':'' }}>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                            <label class="form-label fw-semibold">Description <span class="text-danger">*</span></label>
                            <textarea name="description" rows="5"
                                      class="form-control @error('description') is-invalid @enderror"
                                      placeholder="Describe the issue in detail (minimum 20 characters)…" required>{{ old('description') }}</textarea>
                            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Photo / Attachment <span class="text-muted small">(optional)</span></label>
                            <input type="file" name="attachment"
                                   class="form-control @error('attachment') is-invalid @enderror"
                                   accept=".jpg,.jpeg,.png,.pdf" id="attachmentInput">
                            <div class="form-text">Accepted: JPG, PNG, PDF · Max 5MB</div>
                            @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div id="imagePreview" class="mt-2 d-none">
                                <img id="previewImg" src="" alt="Preview"
                                     class="rounded-3 border" style="max-height:180px;max-width:100%">
                            </div>
                        </div>

                    </div>

                    <div class="alert alert-warning mt-3 mb-0 d-flex gap-2" style="font-size:.82rem">
                        <i class="bi bi-exclamation-triangle-fill flex-shrink-0 mt-1"></i>
                        <span>For urgent issues like gas leaks or electrical hazards, please also call the emergency line immediately.</span>
                    </div>

                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('resident.maintenance.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-warning px-4">
                            <i class="bi bi-send me-2"></i>Submit Request
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('attachmentInput').addEventListener('change', function () {
    const file = this.files[0];
    if (file && file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').classList.add('d-none');
    }
});
</script>
@endpush
