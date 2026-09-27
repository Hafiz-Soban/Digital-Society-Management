@extends('layouts.admin')
@section('title', 'Vehicle Dashboard')
@section('page-title', 'Vehicle Dashboard')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-car-front-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Total Vehicles</h6>
                </div>
                <h3 class="fw-bold mb-0">{{ number_format($stats['total_vehicles']) }}</h3>
                <p class="text-success small mb-0 mt-2">
                    <i class="bi bi-check-circle me-1"></i>{{ $stats['active_vehicles'] }} Active
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                        <i class="bi bi-pause-circle-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Inactive Vehicles</h6>
                </div>
                <h3 class="fw-bold mb-0">{{ number_format($stats['inactive_vehicles']) }}</h3>
                <p class="text-muted small mb-0 mt-2">
                    Not currently in use
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3">
                        <i class="bi bi-question-circle-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Unknown Entries</h6>
                </div>
                <h3 class="fw-bold mb-0">{{ number_format($stats['unknown_entries']) }}</h3>
                <p class="text-danger small mb-0 mt-2">
                    Unregistered vehicles
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-dark bg-opacity-10 text-dark rounded-3 p-2 me-3">
                        <i class="bi bi-exclamation-triangle-fill fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Pending Alerts</h6>
                </div>
                <h3 class="fw-bold mb-0">{{ number_format($stats['suspicious_alerts']) }}</h3>
                <p class="text-danger small mb-0 mt-2">
                    Requires attention
                </p>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Vehicle Logs</h6>
                <a href="{{ route('admin.vehicles.logs.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle #</th>
                                <th>House</th>
                                <th>Status</th>
                                <th>Entry Time</th>
                                <th>Exit Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentLogs as $log)
                            <tr>
                                <td><span class="fw-bold">{{ $log->vehicle_number }}</span></td>
                                <td>{{ $log->house->house_number ?? 'Unknown' }}</td>
                                <td>
                                    @if($log->entry_status == 'verified')
                                        <span class="badge bg-success-subtle text-success">Verified</span>
                                    @elseif($log->entry_status == 'suspicious')
                                        <span class="badge bg-danger-subtle text-danger">Suspicious</span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ $log->entry_time->format('d M, h:i A') }}</td>
                                <td>{{ $log->exit_time ? $log->exit_time->format('d M, h:i A') : '-' }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">No recent logs found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-pie-chart me-2 text-primary"></i>Vehicle Distribution</h6>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    @foreach($vehicleTypes as $type)
                    <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                        <span>{{ ucfirst($type->vehicle_type) }}</span>
                        <span class="badge bg-primary rounded-pill">{{ $type->count }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
