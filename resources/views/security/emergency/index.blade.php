@extends('layouts.security')
@section('title', 'Emergency Alerts')
@section('page-title', 'Emergency Management')

@section('content')
<div class="row g-4">
    {{-- Broadcast New Alert --}}
    <div class="col-lg-4">
        <div class="card shadow-sm border-0 border-top border-4 border-danger">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-megaphone-fill me-2"></i>BROADCAST NEW ALERT</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.emergency.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Alert Title <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="e.g. Fire in Block B" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Emergency Type <span class="text-danger">*</span></label>
                        <select name="type" class="form-select" required>
                            <option value="fire">Fire</option>
                            <option value="medical">Medical</option>
                            <option value="security_threat">Security Threat</option>
                            <option value="natural_disaster">Natural Disaster</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Severity Level <span class="text-danger">*</span></label>
                        <select name="severity" class="form-select" required>
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="critical" selected>Critical</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Location <span class="text-danger">*</span></label>
                        <input type="text" name="location" class="form-control" placeholder="Specific area or house #" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Instructions / Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="4" placeholder="What should residents do?" required></textarea>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-danger fw-bold py-2" onclick="return confirm('This will send a notification to ALL residents and management. Are you sure?')">
                            <i class="bi bi-broadcast me-2"></i>BROADCAST TO ALL
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Alert History --}}
    <div class="col-lg-8">
        @if($activeAlerts->count() > 0)
        <div class="card shadow-sm border-0 mb-4 bg-danger bg-opacity-10 border-start border-4 border-danger">
            <div class="card-header bg-transparent border-0 py-3">
                <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-lightning-fill me-2"></i>ACTIVE ALERTS (REQUIRES ATTENTION)</h6>
            </div>
            <div class="card-body p-0">
                @foreach($activeAlerts as $alert)
                <div class="p-4 border-bottom border-danger border-opacity-25">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <span class="badge bg-danger px-3 py-2 mb-2">{{ strtoupper($alert->type) }}</span>
                            <h4 class="fw-bold mb-1 text-danger">{{ $alert->title }}</h4>
                            <div class="text-dark"><i class="bi bi-geo-alt-fill me-1"></i> <strong>Location:</strong> {{ $alert->location }}</div>
                        </div>
                        <form action="{{ route('security.emergency.resolve', $alert) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="btn btn-success fw-bold">MARK AS RESOLVED</button>
                        </form>
                    </div>
                    <p class="text-dark mb-0">{{ $alert->description }}</p>
                    <div class="mt-3 small text-muted">Broadcasted by: {{ $alert->createdBy->name }} • {{ $alert->created_at->diffForHumans() }}</div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Alert History</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date/Time</th>
                                <th>Alert Type</th>
                                <th>Title</th>
                                <th>Severity</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($alerts as $alert)
                            <tr>
                                <td class="ps-4">
                                    <div class="small fw-bold">{{ $alert->created_at->format('d M, Y') }}</div>
                                    <small class="text-muted">{{ $alert->created_at->format('H:i A') }}</small>
                                </td>
                                <td><span class="badge bg-light text-dark border">{{ ucfirst($alert->type) }}</span></td>
                                <td>
                                    <div class="small fw-bold">{{ $alert->title }}</div>
                                    <small class="text-muted text-truncate d-block" style="max-width: 200px;">{{ $alert->location }}</small>
                                </td>
                                <td>
                                    @php
                                        $sevClass = match($alert->severity) {
                                            'critical' => 'bg-danger',
                                            'high' => 'bg-warning text-dark',
                                            'medium' => 'bg-info',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                    <span class="badge {{ $sevClass }}">{{ ucfirst($alert->severity) }}</span>
                                </td>
                                <td>
                                    @if($alert->status === 'active')
                                        <span class="badge bg-danger">Active</span>
                                    @else
                                        <span class="badge bg-success">Resolved</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="5" class="text-center py-4 text-muted">No emergency alerts recorded.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer bg-white py-3 border-0">
                {{ $alerts->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
