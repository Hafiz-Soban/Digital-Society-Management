@extends('layouts.resident')
@section('title','Edit Profile')
@section('page-title','Edit Profile')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Edit Profile</h5>
        <p class="text-muted small mb-0">Update your personal information</p>
    </div>
    <a href="{{ route('resident.profile.show') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row g-4">
    {{-- Profile Picture --}}
    <div class="col-md-4">
        <div class="card text-center p-4">
            <div class="position-relative d-inline-block mx-auto mb-3">
                <img src="{{ $user->avatar_url }}" class="rounded-circle border border-3 border-primary"
                     width="100" height="100" id="avatarPreview" alt="Avatar" style="object-fit:cover">
            </div>
            <h6 class="fw-bold">{{ $user->name }}</h6>
            <p class="text-muted small">{{ $user->email }}</p>
            <form method="POST" action="{{ route('resident.profile.update') }}" enctype="multipart/form-data" id="avatarForm">
                @csrf @method('PATCH')
                <label class="btn btn-outline-primary btn-sm w-100 mb-2" for="avatarInput">
                    <i class="bi bi-camera me-1"></i>Change Photo
                </label>
                <input type="file" id="avatarInput" name="avatar" class="d-none" accept="image/*"
                       onchange="previewAvatar(this)">
                <p class="text-muted" style="font-size:.72rem">JPG, PNG, WEBP · Max 2MB</p>
            </form>
        </div>
    </div>

    {{-- Edit Form --}}
    <div class="col-md-8">
        <form method="POST" action="{{ route('resident.profile.update') }}" enctype="multipart/form-data">
            @csrf @method('PATCH')

            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-person me-2 text-primary"></i>Personal Information</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                   value="{{ old('name',$user->name) }}" required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label fw-semibold">Phone Number</label>
                            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone',$user->phone) }}" placeholder="+92 300 0000000">
                            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        {{-- Hidden avatar field so form submits it --}}
                        <input type="file" name="avatar" class="d-none" id="avatarHidden">
                    </div>
                </div>
            </div>

            @if($resident)
            <div class="card mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-semibold"><i class="bi bi-telephone-fill me-2 text-danger"></i>Emergency Contact</h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">Contact Name</label>
                            <input type="text" name="emergency_contact_name"
                                   class="form-control @error('emergency_contact_name') is-invalid @enderror"
                                   value="{{ old('emergency_contact_name',$resident->emergency_contact_name) }}">
                            @error('emergency_contact_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">Contact Phone</label>
                            <input type="text" name="emergency_contact_phone"
                                   class="form-control @error('emergency_contact_phone') is-invalid @enderror"
                                   value="{{ old('emergency_contact_phone',$resident->emergency_contact_phone) }}">
                            @error('emergency_contact_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">Relation</label>
                            <input type="text" name="emergency_contact_relation"
                                   class="form-control @error('emergency_contact_relation') is-invalid @enderror"
                                   value="{{ old('emergency_contact_relation',$resident->emergency_contact_relation) }}"
                                   placeholder="Spouse, Parent…">
                            @error('emergency_contact_relation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="d-flex gap-2 justify-content-end">
                <a href="{{ route('resident.profile.show') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-lg me-2"></i>Save Changes
                </button>
            </div>
        </form>

        {{-- Change Password --}}
        <div class="card mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-lock me-2 text-warning"></i>Change Password</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.profile.password') }}">
                    @csrf @method('PATCH')
                    <div class="row g-3">
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password"
                                   class="form-control @error('current_password') is-invalid @enderror" required>
                            @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror" required minlength="8">
                            @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label fw-semibold">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn btn-warning">
                            <i class="bi bi-lock me-2"></i>Change Password
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
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => document.getElementById('avatarPreview').src = e.target.result;
        reader.readAsDataURL(input.files[0]);
        // Copy file to main form
        const dt = new DataTransfer();
        dt.items.add(input.files[0]);
        document.getElementById('avatarHidden').files = dt.files;
    }
}
</script>
@endpush
