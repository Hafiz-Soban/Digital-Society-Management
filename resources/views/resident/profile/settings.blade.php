@extends('layouts.resident')
@section('title','Settings')
@section('page-title','Account Settings')

@section('content')
<div class="mb-4">
    <h5 class="fw-bold mb-1">Settings</h5>
    <p class="text-muted small mb-0">Manage your account preferences</p>
</div>

<div class="row g-4">
    <div class="col-md-8">
        {{-- Change Password --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-lock me-2 text-warning"></i>Change Password</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.profile.password') }}">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Current Password <span class="text-danger">*</span></label>
                        <input type="password" name="current_password"
                               class="form-control @error('current_password') is-invalid @enderror" required>
                        @error('current_password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password"
                               class="form-control @error('password') is-invalid @enderror" required minlength="8">
                        <div class="form-text">Minimum 8 characters</div>
                        @error('password')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Confirm New Password <span class="text-danger">*</span></label>
                        <input type="password" name="password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-warning">
                        <i class="bi bi-lock me-2"></i>Update Password
                    </button>
                </form>
            </div>
        </div>

        {{-- Account Info --}}
        <div class="card mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-info-circle me-2 text-info"></i>Account Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Account Email</label>
                        <div class="fw-semibold">{{ $user->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Account Status</label>
                        <span class="badge bg-success">Active</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Member Since</label>
                        <div class="fw-semibold">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small d-block">Role</label>
                        <span class="badge bg-primary">Resident</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Notification Preferences --}}
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-bell me-2 text-primary"></i>Notification Preferences</h6>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">You receive in-app notifications for the following events:</p>
                <div class="d-flex flex-column gap-2">
                    @foreach([
                        ['icon'=>'bi-chat-square-text','label'=>'Complaint status updates','color'=>'primary'],
                        ['icon'=>'bi-tools','label'=>'Maintenance request updates','color'=>'warning'],
                        ['icon'=>'bi-person-badge','label'=>'Visitor approvals','color'=>'info'],
                        ['icon'=>'bi-exclamation-triangle','label'=>'Emergency alerts','color'=>'danger'],
                        ['icon'=>'bi-megaphone','label'=>'New notices & announcements','color'=>'success'],
                    ] as $pref)
                    <div class="d-flex align-items-center gap-3 p-2 rounded-2 bg-light">
                        <i class="bi {{ $pref['icon'] }} text-{{ $pref['color'] }} fs-5"></i>
                        <span style="font-size:.875rem">{{ $pref['label'] }}</span>
                        <span class="badge bg-success ms-auto">Enabled</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center p-4">
                <img src="{{ $user->avatar_url }}" class="rounded-circle border border-3 border-primary mb-3"
                     width="80" height="80" alt="Avatar" style="object-fit:cover">
                <h6 class="fw-bold">{{ $user->name }}</h6>
                <p class="text-muted small">{{ $user->email }}</p>
                <a href="{{ route('resident.profile.edit') }}" class="btn btn-outline-primary btn-sm w-100 mb-2">
                    <i class="bi bi-pencil me-1"></i>Edit Profile
                </a>
                <a href="{{ route('resident.profile.show') }}" class="btn btn-outline-secondary btn-sm w-100">
                    <i class="bi bi-person me-1"></i>View Profile
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
