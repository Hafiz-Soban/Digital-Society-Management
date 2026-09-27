@extends('layouts.security')
@section('title', 'Edit Profile')
@section('page-title', 'Edit Profile Information')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Update Profile Details</h6>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('security.profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PATCH')
                    
                    <div class="row g-4">
                        <div class="col-12 text-center mb-2">
                            <img src="{{ $user->avatar_url }}" class="rounded-circle border p-1 mb-3" width="120" height="150" style="object-fit: cover;" id="avatarPreview">
                            <div class="mt-2">
                                <label class="btn btn-sm btn-outline-danger px-3">
                                    Change Photo
                                    <input type="file" name="avatar" class="d-none" accept="image/*" onchange="previewImage(this)">
                                </label>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $user->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label small fw-bold">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $user->phone) }}">
                            @error('phone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold">Email Address (Read-only)</label>
                            <input type="email" class="form-control bg-light" value="{{ $user->email }}" readonly>
                            <div class="form-text small">Email cannot be changed from this portal. Contact Admin for email updates.</div>
                        </div>

                        <div class="col-12 text-end mt-5">
                            <a href="{{ route('security.profile.show') }}" class="btn btn-light px-4 me-2">Cancel</a>
                            <button type="submit" class="btn btn-danger px-4 fw-bold">Save Changes</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatarPreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
