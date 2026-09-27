@extends('layouts.admin')

@section('title', 'Staff Dashboard')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Staff Dashboard</h2>
        <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
            <i class="bi bi-person-plus-fill me-2"></i>Add New Staff
        </a>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-4">
        <div class="col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="bi bi-people-fill fs-3"></i>
                        <span class="badge bg-white text-primary">Total</span>
                    </div>
                    <h3 class="h2 fw-bold mb-1">{{ $stats['total_staff'] }}</h3>
                    <p class="mb-0 opacity-75 small">Total Staff</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="bi bi-person-check-fill fs-3"></i>
                        <span class="badge bg-white text-success">Active</span>
                    </div>
                    <h3 class="h2 fw-bold mb-1">{{ $stats['active_staff'] }}</h3>
                    <p class="mb-0 opacity-75 small">Active Staff</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="bi bi-shield-shaded fs-3"></i>
                        <span class="badge bg-white text-info">Guard</span>
                    </div>
                    <h3 class="h2 fw-bold mb-1">{{ $stats['security_guards'] }}</h3>
                    <p class="mb-0 opacity-75 small">Security Guards</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="bi bi-person-badge fs-3"></i>
                        <span class="badge bg-dark text-white">Supervisor</span>
                    </div>
                    <h3 class="h2 fw-bold mb-1">{{ $stats['supervisors'] }}</h3>
                    <p class="mb-0 opacity-75 small">Supervisors</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="bi bi-cash-stack fs-3"></i>
                    </div>
                    <h3 class="h2 fw-bold mb-1">Rs. {{ number_format($stats['monthly_salary_expense'] / 1000, 1) }}K</h3>
                    <p class="mb-0 opacity-75 small">Monthly Expense</p>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-lg-2">
            <div class="card border-0 shadow-sm h-100 bg-dark text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <i class="bi bi-arrow-down-left-circle fs-3"></i>
                    </div>
                    <h3 class="h2 fw-bold mb-1">Rs. {{ number_format($stats['total_advances'] / 1000, 1) }}K</h3>
                    <p class="mb-0 opacity-75 small">Total Advances</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <!-- Quick Links -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">Quick Management</h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.staff.attendance.index') }}" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="bi bi-calendar-check fs-4 me-3 text-primary"></i>
                            <div>
                                <h6 class="mb-0">Staff Attendance</h6>
                                <small class="text-muted">Record or view daily attendance logs</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto text-muted"></i>
                        </a>
                        <a href="{{ route('admin.staff-salaries.index') }}" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="bi bi-wallet2 fs-4 me-3 text-success"></i>
                            <div>
                                <h6 class="mb-0">Salary Management</h6>
                                <small class="text-muted">Track monthly salary payments and status</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto text-muted"></i>
                        </a>
                        <a href="{{ route('admin.staff-advances.index') }}" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="bi bi-cash fs-4 me-3 text-warning"></i>
                            <div>
                                <h6 class="mb-0">Advance Salary</h6>
                                <small class="text-muted">Manage advance requests and history</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto text-muted"></i>
                        </a>
                        <a href="{{ route('admin.emergency-contacts.index') }}" class="list-group-item list-group-item-action py-3 d-flex align-items-center">
                            <i class="bi bi-telephone-outbound fs-4 me-3 text-danger"></i>
                            <div>
                                <h6 class="mb-0">Emergency Contacts</h6>
                                <small class="text-muted">Society-wide emergency directory</small>
                            </div>
                            <i class="bi bi-chevron-right ms-auto text-muted"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Staff Added -->
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Recently Joined Staff</h5>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-link">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <tbody>
                                @php $recentStaff = \App\Models\Staff::latest()->limit(5)->get(); @endphp
                                @forelse($recentStaff as $staff)
                                <tr>
                                    <td class="ps-4">
                                        @if($staff->photo_path)
                                            <img src="{{ asset('storage/' . $staff->photo_path) }}" class="rounded-circle" width="32" height="32" alt="">
                                        @else
                                            <div class="rounded-circle bg-light d-flex align-items-center justify-content-center" style="width: 32px; height: 32px;">
                                                <i class="bi bi-person text-muted" style="font-size: 0.8rem;"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $staff->full_name }}</div>
                                        <small class="text-muted">{{ $staff->designation }}</small>
                                    </td>
                                    <td>{{ $staff->joining_date->format('d M, Y') }}</td>
                                    <td class="text-end pe-4">
                                        <a href="{{ route('admin.staff.show', $staff) }}" class="btn btn-sm btn-light">Profile</a>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="text-center py-4 text-muted">No staff members found.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
