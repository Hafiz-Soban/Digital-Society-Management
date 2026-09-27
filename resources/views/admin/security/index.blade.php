@extends('layouts.admin')
@section('title', 'Security Logs')
@section('page-title', 'Security Logs')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Security Logs</h5>
        <p class="text-muted small mb-0">Monitor all security events and activities</p>
    </div>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by description, user..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="event_type" class="form-select">
                    <option value="">All Event Types</option>
                    <option value="login" {{ request('event_type') == 'login' ? 'selected' : '' }}>Login</option>
                    <option value="logout" {{ request('event_type') == 'logout' ? 'selected' : '' }}>Logout</option>
                    <option value="visitor_entry" {{ request('event_type') == 'visitor_entry' ? 'selected' : '' }}>Visitor Entry</option>
                    <option value="visitor_exit" {{ request('event_type') == 'visitor_exit' ? 'selected' : '' }}>Visitor Exit</option>
                    <option value="gate_open" {{ request('event_type') == 'gate_open' ? 'selected' : '' }}>Gate Open</option>
                    <option value="alarm" {{ request('event_type') == 'alarm' ? 'selected' : '' }}>Alarm</option>
                    <option value="patrol" {{ request('event_type') == 'patrol' ? 'selected' : '' }}>Patrol</option>
                    <option value="incident" {{ request('event_type') == 'incident' ? 'selected' : '' }}>Incident</option>
                    <option value="other" {{ request('event_type') == 'other' ? 'selected' : '' }}>Other</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="severity" class="form-select">
                    <option value="">All Severity</option>
                    <option value="info" {{ request('severity') == 'info' ? 'selected' : '' }}>Info</option>
                    <option value="warning" {{ request('severity') == 'warning' ? 'selected' : '' }}>Warning</option>
                    <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" class="form-control" value="{{ request('date') }}" placeholder="Filter by date">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-1">
                <a href="{{ route('admin.security.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Event Type</th>
                        <th>Description</th>
                        <th>Severity</th>
                        <th>Logged By</th>
                        <th>IP Address</th>
                        <th>Timestamp</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                    <tr class="{{ $log->severity == 'critical' ? 'table-danger' : ($log->severity == 'warning' ? 'table-warning' : '') }}">
                        <td>
                            @php
                                $eventIcons = [
                                    'login' => 'bi-box-arrow-in-right',
                                    'logout' => 'bi-box-arrow-right',
                                    'visitor_entry' => 'bi-person-check',
                                    'visitor_exit' => 'bi-person-dash',
                                    'gate_open' => 'bi-door-open',
                                    'alarm' => 'bi-bell',
                                    'patrol' => 'bi-shield',
                                    'incident' => 'bi-exclamation-triangle',
                                ];
                                $icon = $eventIcons[$log->event_type] ?? 'bi-activity';
                            @endphp
                            <div class="d-flex align-items-center gap-2">
                                <i class="bi {{ $icon }} text-primary"></i>
                                <span class="badge bg-light text-dark border">{{ ucwords(str_replace('_', ' ', $log->event_type)) }}</span>
                            </div>
                        </td>
                        <td>
                            <div>{{ Str::limit($log->description, 60) }}</div>
                            @if($log->metadata)
                                <div class="text-muted small">{{ Str::limit(json_encode($log->metadata), 50) }}</div>
                            @endif
                        </td>
                        <td>
                            @if($log->severity == 'critical')
                                <span class="badge bg-danger">Critical</span>
                            @elseif($log->severity == 'warning')
                                <span class="badge bg-warning text-dark">Warning</span>
                            @else
                                <span class="badge bg-info text-white">Info</span>
                            @endif
                        </td>
                        <td>
                            @if($log->loggedBy)
                                <div class="fw-semibold small">{{ $log->loggedBy->name }}</div>
                                <div class="text-muted small">{{ $log->loggedBy->role->name ?? '-' }}</div>
                            @else
                                <span class="text-muted small">System</span>
                            @endif
                        </td>
                        <td><code class="small">{{ $log->ip_address ?? '-' }}</code></td>
                        <td>
                            <div class="small">{{ $log->created_at->format('d M Y') }}</div>
                            <div class="text-muted small">{{ $log->created_at->format('H:i:s') }}</div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-shield-check fs-1 d-block mb-2"></i>
                            No security logs found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($logs->hasMorePages())
=======
    @if($logs->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $logs->links() }}
    </div>
    @endif
</div>
@endsection
