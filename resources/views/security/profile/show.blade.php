@extends('layouts.security')
@section('title', 'My Profile')
@section('page-title', 'Security Guard Profile')

@section('content')
<div class="row g-4">
    <div class="col-md-4">
        <div class="card shadow-sm border-0 text-center p-4">
            <div class="mb-3">
                <img src="{{ $user->avatar_url }}" class="rounded-circle border p-1" width="150" height="150" style="object-fit: cover;">
            </div>
            <h5 class="fw-bold mb-1">{{ $user->name }}</h5>
            <p class="text-muted small mb-3">Security Guard</p>
            <div class="d-grid gap-2">
                <a href="{{ route('security.profile.edit') }}" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-pencil me-1"></i> Edit Profile
                </a>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Change Password</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.profile.password') }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Current Password</label>
                        <input type="password" name="current_password" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">New Password</label>
                        <input type="password" name="password" class="form-control form-control-sm" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control form-control-sm" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-dark btn-sm fw-bold">Update Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Personal Information</h6>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold d-block text-uppercase">Full Name</label>
                        <div class="text-dark fw-bold">{{ $user->name }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold d-block text-uppercase">Email Address</label>
                        <div class="text-dark fw-bold">{{ $user->email }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold d-block text-uppercase">Phone Number</label>
                        <div class="text-dark fw-bold">{{ $user->phone ?? 'Not provided' }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold d-block text-uppercase">Account Role</label>
                        <span class="badge bg-danger">Security Guard</span>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold d-block text-uppercase">Member Since</label>
                        <div class="text-dark fw-bold">{{ $user->created_at->format('d M Y') }}</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="text-muted small fw-bold d-block text-uppercase">Account Status</label>
                        <span class="badge bg-success">Active</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Duty Stats (Life-time)</h6>
            </div>
            <div class="card-body">
                <div class="row text-center g-3">
                    <div class="col-md-3">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fs-4 fw-bold text-danger">{{ \App\Models\Visitor::where('approved_by', $user->id)->count() }}</div>
                            <div class="small text-muted">Visitors Approved</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fs-4 fw-bold text-danger">{{ \App\Models\SecurityIncident::where('reported_by', $user->id)->count() }}</div>
                            <div class="small text-muted">Incidents Reported</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fs-4 fw-bold text-danger">{{ \App\Models\EmergencyAlert::where('created_by', $user->id)->count() }}</div>
                            <div class="small text-muted">Emergencies Broadcasted</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 border rounded-3 bg-light">
                            <div class="fs-4 fw-bold text-danger">{{ \App\Models\SecurityLog::where('logged_by', $user->id)->count() }}</div>
                            <div class="small text-muted">Total Log Entries</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
