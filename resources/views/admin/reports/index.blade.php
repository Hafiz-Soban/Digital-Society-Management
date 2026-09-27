@extends('layouts.admin')
@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Reports</h5>
        <p class="text-muted small mb-0">Generate and view detailed society reports</p>
    </div>
</div>

<!-- Report Cards -->
<div class="row g-4">
    <!-- Residents Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-people text-primary fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Residents Report</h6>
                <p class="text-muted small mb-3">Analyze resident data, occupancy rates, move-in/out trends and ownership breakdown.</p>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-primary">{{ $stats['total_residents'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Total</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-success">{{ $stats['active_residents'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Active</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.reports.residents') }}" class="btn btn-primary w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Visitors Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-person-badge text-info fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Visitors Report</h6>
                <p class="text-muted small mb-3">Track visitor frequency, peak hours, approval rates and visitor patterns over time.</p>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-info">{{ $stats['total_visitors'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Total</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-success">{{ $stats['visitors_today'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Today</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.reports.visitors') }}" class="btn btn-info text-white w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Complaints Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-warning bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-chat-square-text text-warning fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Complaints Report</h6>
                <p class="text-muted small mb-3">Review complaint trends, resolution times, category breakdown and priority distribution.</p>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-warning">{{ $stats['total_complaints'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Total</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-danger">{{ $stats['open_complaints'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Open</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.reports.complaints') }}" class="btn btn-warning text-white w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Maintenance Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-tools text-success fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Maintenance Report</h6>
                <p class="text-muted small mb-3">Analyze maintenance requests, staff performance, completion rates and cost tracking.</p>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-success">{{ $stats['total_maintenance'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Total</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="bg-light rounded-2 p-2">
                            <div class="fw-bold text-warning">{{ $stats['pending_maintenance'] ?? 0 }}</div>
                            <div class="text-muted" style="font-size:0.7rem">Pending</div>
                        </div>
                    </div>
                </div>
                <a href="{{ route('admin.reports.maintenance') }}" class="btn btn-success w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>
<<<<<<< HEAD

    <!-- Vehicles Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-secondary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-car-front text-secondary fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Vehicles Report</h6>
                <p class="text-muted small mb-3">Monitor vehicle registration, entry logs, alerts and suspicious activity.</p>
                <a href="{{ route('admin.reports.vehicles') }}" class="btn btn-secondary w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Staff Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-primary bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-person-badge text-primary fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Staff Report</h6>
                <p class="text-muted small mb-3">Comprehensive staff details, roles, and employment status report.</p>
                <a href="{{ route('admin.reports.staff') }}" class="btn btn-primary w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Attendance Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-success bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-calendar-check text-success fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Attendance Report</h6>
                <p class="text-muted small mb-3">Daily and monthly attendance records and patterns for all staff.</p>
                <a href="{{ route('admin.reports.attendance') }}" class="btn btn-success w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Salary Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-info bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-wallet2 text-info fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Salary Report</h6>
                <p class="text-muted small mb-3">Monthly salary distribution, pending payments, and total expenses.</p>
                <a href="{{ route('admin.reports.salaries') }}" class="btn btn-info text-white w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Advances Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-warning bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-cash-stack text-warning fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Advances Report</h6>
                <p class="text-muted small mb-3">Salary advances given, reasons, and remaining salary balances.</p>
                <a href="{{ route('admin.reports.advances') }}" class="btn btn-warning text-white w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>

    <!-- Deleted Records Report -->
    <div class="col-md-6 col-xl-3">
        <div class="card h-100 border-0 shadow-sm">
            <div class="card-body text-center p-4">
                <div class="bg-danger bg-opacity-10 rounded-3 d-inline-flex align-items-center justify-content-center mb-3" style="width:70px;height:70px">
                    <i class="bi bi-trash text-danger fs-2"></i>
                </div>
                <h6 class="fw-bold mb-2">Deleted Records</h6>
                <p class="text-muted small mb-3">Audit trail of all deleted records across all modules.</p>
                <a href="{{ route('admin.reports.deleted') }}" class="btn btn-danger w-100">
                    <i class="bi bi-bar-chart me-2"></i>View Report
                </a>
            </div>
        </div>
    </div>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
</div>

<!-- Quick Summary -->
<div class="row g-4 mt-2">
    <div class="col-12">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-graph-up me-2 text-primary"></i>Quick Overview — This Month</h6>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-3 text-center">
                        <div class="fw-bold fs-3 text-primary">{{ $monthlyStats['new_residents'] ?? 0 }}</div>
                        <div class="text-muted small">New Residents</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="fw-bold fs-3 text-info">{{ $monthlyStats['visitors'] ?? 0 }}</div>
                        <div class="text-muted small">Visitor Entries</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="fw-bold fs-3 text-warning">{{ $monthlyStats['complaints'] ?? 0 }}</div>
                        <div class="text-muted small">Complaints Filed</div>
                    </div>
                    <div class="col-md-3 text-center">
                        <div class="fw-bold fs-3 text-success">{{ $monthlyStats['maintenance_completed'] ?? 0 }}</div>
                        <div class="text-muted small">Maintenance Completed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
