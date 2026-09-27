@extends('layouts.admin')
@section('title', 'Settings — User Management')
@section('page-title', 'Settings')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">User Management</h5>
        <p class="text-muted small mb-0">Manage admin and staff user accounts</p>
    </div>
<<<<<<< HEAD
    <a href="{{ route('admin.settings.users.create') }}" class="btn btn-primary">
=======
    <a href="{{ route('admin.settings.create-user') }}" class="btn btn-primary">
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        <i class="bi bi-person-plus me-2"></i>Create User
    </a>
</div>

<!-- Search -->
<div class="row g-4 mb-4">
    <div class="col-lg-8">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-search me-2 text-primary"></i>Filter Users</h6>
            </div>
            <div class="card-body">
                <form method="GET" class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Search by name or email..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="role_id" class="form-select">
                            <option value="">All Roles</option>
                            @foreach($roles ?? [] as $role)
                                <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select name="status" class="form-select">
                            <option value="">All Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 text-end">
                        <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-secondary px-4 me-2">Reset</a>
                        <button type="submit" class="btn btn-primary px-4">Filter</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-shield-lock me-2 text-warning"></i>Registration Settings</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.settings.registration') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Require Admin Approval After Registration</label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="require_admin_approval" id="approval_yes" value="yes" {{ $requireApproval == 'yes' ? 'checked' : '' }}>
                                <label class="form-check-label" for="approval_yes">Yes</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="require_admin_approval" id="approval_no" value="no" {{ $requireApproval == 'no' ? 'checked' : '' }}>
                                <label class="form-check-label" for="approval_no">No</label>
                            </div>
                        </div>
                        <small class="text-muted">If enabled, newly registered owner accounts will remain 'Pending' until approved by an administrator.</small>
                    </div>
                    <button type="submit" class="btn btn-warning w-100 fw-bold">Update Registration Settings</button>
                </form>
<<<<<<< HEAD
=======

                <hr class="my-4">

                <form method="POST" action="{{ route('admin.settings.maintenance-restriction') }}">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Maintenance Due Restriction</label>
                        <div class="form-check form-switch mb-2">
                            <input class="form-check-input" type="checkbox" role="switch" id="maintenance_restriction" name="maintenance_restriction_enabled" value="1" {{ $maintenanceRestriction == '1' ? 'checked' : '' }}>
                            <label class="form-check-label" for="maintenance_restriction">Enable Restrictions</label>
                        </div>
                        <input type="hidden" name="maintenance_restriction_enabled" value="0" id="maintenance_restriction_hidden">
                        <small class="text-muted">When enabled, residents with more than Rs. 10,000 due maintenance will have limited access (only Fire & Emergency alerts enabled).</small>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 fw-bold">Update Restriction Settings</button>
                </form>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
            </div>
        </div>
    </div>
</div>

<<<<<<< HEAD
=======
<script>
    document.getElementById('maintenance_restriction').addEventListener('change', function() {
        document.getElementById('maintenance_restriction_hidden').disabled = this.checked;
    });
    // Initialize
    document.getElementById('maintenance_restriction_hidden').disabled = document.getElementById('maintenance_restriction').checked;
</script>

>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $user->avatar_url }}" class="rounded-circle" width="36" height="36" alt="">
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                    @if($user->id == auth()->id())
                                        <span class="badge bg-primary" style="font-size:0.65rem">You</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone ?? '-' }}</td>
                        <td>
                            @php
                                $roleColors = ['admin' => 'danger', 'super_admin' => 'dark', 'staff' => 'info', 'security' => 'warning'];
                                $roleSlug = Str::slug($user->role->name ?? 'staff', '_');
                                $roleColor = $roleColors[$roleSlug] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $roleColor }}">{{ $user->role->name ?? '-' }}</span>
                        </td>
                        <td>
                            @if($user->status == 'active')
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d M Y') }}</td>
                        <td>
                            <div class="d-flex gap-1">
                                <!-- Toggle Status -->
                                @if($user->id != auth()->id())
                                <form method="POST" action="{{ route('admin.settings.users.status', $user) }}">
                                    @csrf @method('PATCH')
<<<<<<< HEAD
                                    <input type="hidden" name="status" value="{{ $user->status == 'active' ? 'inactive' : 'active' }}">
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                                    <button type="submit" class="btn btn-sm {{ $user->status == 'active' ? 'btn-outline-warning' : 'btn-outline-success' }}"
                                        title="{{ $user->status == 'active' ? 'Deactivate' : 'Activate' }}">
                                        <i class="bi {{ $user->status == 'active' ? 'bi-pause-circle' : 'bi-play-circle' }}"></i>
                                    </button>
                                </form>

                                <!-- Delete -->
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteUserModal{{ $user->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteUserModal{{ $user->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-sm">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h6 class="modal-title">Confirm Delete</h6>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="mb-0">Delete user <strong>{{ $user->name }}</strong>? This cannot be undone.</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form method="POST" action="{{ route('admin.settings.users.destroy', $user) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @else
                                <span class="text-muted small">Current user</span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            No users found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($users->hasMorePages())
=======
    @if($users->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $users->links() }}
    </div>
    @endif
</div>
@endsection
