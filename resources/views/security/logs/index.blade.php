@extends('layouts.security')
@section('title', 'Security Logs')
@section('page-title', 'Entry/Exit & Activity Logs')

@section('content')
<div class="row g-4">
    {{-- Filter and Add Log --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Filter Logs</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.logs.index') }}" method="GET" class="row g-3">
                    <div class="col-12">
                        <label class="form-label small fw-bold">Search Keywords</label>
                        <input type="text" name="search" class="form-control" placeholder="Description, location..." value="{{ request('search') }}">
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Event Type</label>
                        <select name="event_type" class="form-select">
                            <option value="">All Types</option>
                            <option value="visitor_entry" {{ request('event_type') == 'visitor_entry' ? 'selected' : '' }}>Visitor Entry</option>
                            <option value="visitor_exit" {{ request('event_type') == 'visitor_exit' ? 'selected' : '' }}>Visitor Exit</option>
                            <option value="incident" {{ request('event_type') == 'incident' ? 'selected' : '' }}>Incident</option>
                            <option value="patrol" {{ request('event_type') == 'patrol' ? 'selected' : '' }}>Patrol</option>
                            <option value="alert" {{ request('event_type') == 'alert' ? 'selected' : '' }}>Alert</option>
                            <option value="other" {{ request('event_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Severity</label>
                        <select name="severity" class="form-select">
                            <option value="">All Severities</option>
                            <option value="info" {{ request('severity') == 'info' ? 'selected' : '' }}>Info</option>
                            <option value="warning" {{ request('severity') == 'warning' ? 'selected' : '' }}>Warning</option>
                            <option value="critical" {{ request('severity') == 'critical' ? 'selected' : '' }}>Critical</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <label class="form-label small fw-bold">Date</label>
                        <input type="date" name="date" class="form-control" value="{{ request('date') }}">
                    </div>
                    <div class="col-12 d-grid">
                        <button type="submit" class="btn btn-primary">Apply Filters</button>
                        <a href="{{ route('security.logs.index') }}" class="btn btn-link btn-sm mt-2 text-decoration-none text-muted">Clear Filters</a>
                    </div>
                </form>
            </div>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-plus-lg me-2"></i>RECORD MANUAL ACTIVITY</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.logs.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Activity Type</label>
                        <select name="event_type" class="form-select" required>
                            <option value="patrol">Patrol Duty</option>
                            <option value="incident">Incident Observation</option>
                            <option value="alert">Security Alert</option>
                            <option value="other">Other Activity</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Location</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. Block C Perimeter" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Severity</label>
                        <select name="severity" class="form-select" required>
                            <option value="info">Info (Normal)</option>
                            <option value="warning">Warning (Suspicious)</option>
                            <option value="critical">Critical (Immediate Action)</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Description</label>
                        <textarea name="description" class="form-control" rows="3" placeholder="Describe what happened..." required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger fw-bold">SAVE LOG ENTRY</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Log Table --}}
    <div class="col-lg-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold">Security Activity Feed</h6>
                <button class="btn btn-sm btn-outline-dark px-3"><i class="bi bi-download me-1"></i>Export Logs</button>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Timestamp</th>
                                <th>Type</th>
                                <th>Description / Location</th>
                                <th>Severity</th>
                                <th class="pe-4">Logged By</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td class="ps-4">
                                    <div class="small fw-bold">{{ $log->created_at->format('d M, Y') }}</div>
                                    <small class="text-muted">{{ $log->created_at->format('H:i:s') }}</small>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border small">{{ str_replace('_', ' ', ucfirst($log->event_type)) }}</span>
                                </td>
                                <td>
                                    <div class="small fw-bold text-dark">{{ Str::limit($log->description, 60) }}</div>
                                    <small class="text-muted"><i class="bi bi-geo-alt me-1"></i>{{ $log->location ?? 'N/A' }}</small>
                                </td>
                                <td>{!! $log->severity_badge !!}</td>
                                <td class="pe-4">
                                    <small class="text-muted">{{ $log->loggedBy->name }}</small>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-5 text-muted">No security logs found matching your criteria.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3 border-0">
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
