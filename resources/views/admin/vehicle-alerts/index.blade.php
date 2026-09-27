@extends('layouts.admin')
@section('title', 'Suspicious Vehicle Alerts')
@section('page-title', 'Vehicle Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Suspicious Vehicle Alerts</h5>
        <p class="text-muted small mb-0">Rule-based security alerts for unknown or frequent vehicles</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <div class="d-flex gap-2">
            <a href="{{ route('admin.vehicles.alerts.index') }}" class="btn btn-sm {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">All Alerts</a>
            <a href="{{ route('admin.vehicles.alerts.index', ['status' => 'pending']) }}" class="btn btn-sm {{ request('status') == 'pending' ? 'btn-primary' : 'btn-outline-primary' }}">Pending</a>
            <a href="{{ route('admin.vehicles.alerts.index', ['status' => 'resolved']) }}" class="btn btn-sm {{ request('status') == 'resolved' ? 'btn-primary' : 'btn-outline-primary' }}">Resolved</a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Date & Time</th>
                        <th>Vehicle #</th>
                        <th>Alert Type</th>
                        <th>Reason</th>
                        <th>Security Guard</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alerts as $alert)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $alert->created_at->format('d M, Y') }}</div>
                            <div class="small text-muted">{{ $alert->created_at->format('h:i A') }}</div>
                        </td>
                        <td><span class="fw-bold text-danger">{{ $alert->vehicle_number }}</span></td>
                        <td>
                            @php
                                $typeLabels = [
                                    'repeated_unknown' => 'Frequent Unknown',
                                    'multiple_houses' => 'Multi-House Visit',
                                    'late_night' => 'Late Night Entry',
                                ];
                            @endphp
                            <span class="badge bg-danger-subtle text-danger">
                                {{ $typeLabels[$alert->alert_type] ?? ucfirst($alert->alert_type) }}
                            </span>
                        </td>
                        <td style="max-width: 250px;"><small>{{ $alert->reason }}</small></td>
                        <td>{{ $alert->securityGuard->name ?? 'System' }}</td>
                        <td>
                            @if($alert->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @else
                                <span class="badge bg-success">Resolved</span>
                            @endif
                        </td>
                        <td>
                            @if($alert->status == 'pending')
                                <form action="{{ route('admin.vehicles.alerts.resolve', $alert) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-success">Resolve</button>
                                </form>
                            @else
                                <span class="text-success"><i class="bi bi-check-circle-fill"></i></span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No suspicious alerts found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($alerts->hasMorePages())
    <div class="card-footer bg-white border-0">
        {{ $alerts->links() }}
    </div>
    @endif
</div>
@endsection
