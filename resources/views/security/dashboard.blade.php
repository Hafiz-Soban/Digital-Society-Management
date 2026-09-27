@extends('layouts.security')
@section('title', 'Security Dashboard')
@section('page-title', 'Security Dashboard')

@section('content')
{{-- Quick Stats --}}
<div class="row g-3 mb-4">
    <div class="col-md-3">
        <div class="card bg-primary text-white p-3 h-100">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small opacity-75">Total Visitors Today</div>
                    <div class="fs-3 fw-bold">{{ $stats['total_visitors_today'] }}</div>
                </div>
                <i class="bi bi-people fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white p-3 h-100">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small opacity-75">Approved Today</div>
                    <div class="fs-3 fw-bold">{{ $stats['approved_visitors'] }}</div>
                </div>
                <i class="bi bi-check-circle fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark p-3 h-100">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small opacity-75">Pending Requests</div>
                    <div class="fs-3 fw-bold">{{ $stats['pending_requests'] }}</div>
                </div>
                <i class="bi bi-clock-history fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-danger text-white p-3 h-100">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="small opacity-75">Active Alerts</div>
                    <div class="fs-3 fw-bold">{{ $stats['active_alerts'] }}</div>
                </div>
                <i class="bi bi-exclamation-triangle fs-1 opacity-25"></i>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    {{-- Left Column: Active Alerts and Recent Visitors --}}
    <div class="col-lg-8">
        @if($activeAlerts->count() > 0)
        <div class="card mb-4 border-start border-4 border-danger">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 text-danger fw-bold"><i class="bi bi-lightning-fill me-2"></i>ACTIVE EMERGENCY ALERTS</h6>
            </div>
            <div class="card-body p-0">
                @foreach($activeAlerts as $alert)
                <div class="p-3 border-bottom d-flex justify-content-between align-items-center">
                    <div>
                        <span class="badge bg-danger mb-1">{{ strtoupper($alert->type) }}</span>
                        <h6 class="mb-0 fw-bold">{{ $alert->title }}</h6>
                        <small class="text-muted">{{ $alert->location }} • {{ $alert->created_at->diffForHumans() }}</small>
                    </div>
                    <a href="{{ route('security.emergency.index') }}" class="btn btn-sm btn-outline-danger">Respond</a>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-primary">TODAY'S VISITOR ENTRIES</h6>
                <a href="{{ route('security.visitors.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-3">Visitor</th>
                                <th>Resident/House</th>
                                <th>Status</th>
                                <th class="text-end pe-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisitors as $visitor)
                            <tr>
                                <td class="ps-3">
                                    <div class="fw-bold">{{ $visitor->visitor_name }}</div>
                                    <small class="text-muted">{{ $visitor->visitor_phone }}</small>
                                </td>
                                <td>
                                    <div>{{ $visitor->resident->user->name ?? 'N/A' }}</div>
                                    <small class="text-muted">House: {{ $visitor->resident->house->house_number ?? 'N/A' }}</small>
                                </td>
                                <td>{!! $visitor->status_badge !!}</td>
                                <td class="text-end pe-3">
                                    <a href="{{ route('security.visitors.show', $visitor) }}" class="btn btn-sm btn-light">Details</a>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-4 text-muted">No visitor entries today</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Right Column: Recent Incidents and Logs --}}
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-dark">RECENT INCIDENTS</h6>
                <a href="{{ route('security.incidents.index') }}" class="btn btn-sm btn-link text-decoration-none">View All</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentIncidents as $incident)
                <div class="p-3 border-bottom">
                    <div class="d-flex justify-content-between mb-1">
                        <span class="badge bg-{{ $incident->status === 'reported' ? 'danger' : 'warning' }} small">{{ $incident->type_label }}</span>
                        <small class="text-muted">{{ $incident->created_at->diffForHumans() }}</small>
                    </div>
                    <h6 class="mb-1 fw-bold" style="font-size: 0.9rem;">{{ $incident->title }}</h6>
                    <small class="text-muted d-block text-truncate">{{ $incident->location }}</small>
                </div>
                @empty
                <div class="p-4 text-center text-muted">No recent incidents</div>
                @endforelse
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-dark">SECURITY LOGS</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @forelse($recentLogs as $log)
                    <div class="list-group-item px-3 py-2 border-0">
                        <div class="d-flex gap-3">
                            <div class="bg-light rounded-circle p-2 text-primary" style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-activity"></i>
                            </div>
                            <div class="flex-grow-1">
                                <div class="small fw-bold">{{ $log->event_type }}</div>
                                <div class="text-muted" style="font-size: 0.75rem;">{{ Str::limit($log->description, 50) }}</div>
                                <small class="text-muted opacity-75" style="font-size: 0.7rem;">{{ $log->created_at->format('H:i A') }}</small>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="p-4 text-center text-muted">No activity logs</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
