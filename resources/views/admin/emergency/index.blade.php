@extends('layouts.admin')
@section('title', 'Emergency Alerts')
@section('page-title', 'Emergency Alerts')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Emergency Alerts</h5>
        <p class="text-muted small mb-0">Monitor and manage emergency situations</p>
    </div>
    <a href="{{ route('admin.emergency.create') }}" class="btn btn-danger">
        <i class="bi bi-exclamation-triangle me-2"></i>Create Alert
    </a>
</div>

<!-- Stats Cards -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-danger text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-exclamation-triangle text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Active Alerts</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-clock text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['today'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Today</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-check-circle text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['resolved'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Resolved</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-shield-exclamation text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Active Alerts (highlighted) -->
@if(isset($activeAlerts) && $activeAlerts->count() > 0)
<div class="alert alert-danger border-danger mb-4">
    <div class="d-flex align-items-center gap-2 mb-2">
        <i class="bi bi-exclamation-triangle-fill fs-5"></i>
        <strong>{{ $activeAlerts->count() }} Active Emergency Alert(s)</strong>
    </div>
    @foreach($activeAlerts as $alert)
    <div class="d-flex justify-content-between align-items-center {{ !$loop->last ? 'border-bottom border-danger pb-2 mb-2' : '' }}">
        <div>
            <div class="fw-semibold">{{ $alert->title }}</div>
            <div class="small">{{ Str::limit($alert->description, 80) }}</div>
            <div class="small text-muted">{{ $alert->created_at->diffForHumans() }} — by {{ $alert->createdBy->name ?? 'System' }}</div>
        </div>
        <button type="button" class="btn btn-sm btn-outline-light ms-3"
            data-bs-toggle="modal" data-bs-target="#resolveModal{{ $alert->id }}">
            <i class="bi bi-check-circle me-1"></i>Resolve
        </button>
    </div>
    @endforeach
</div>
@endif

<!-- All Alerts Table -->
<div class="card">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold">All Emergency Alerts</h6>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Severity</th>
                        <th>Status</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Resolved At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($alerts as $alert)
                    <tr class="{{ $alert->status == 'active' ? 'table-danger' : '' }}">
                        <td>
                            <div class="fw-semibold">{{ $alert->title }}</div>
                            <div class="text-muted small">{{ Str::limit($alert->description, 50) }}</div>
                        </td>
                        <td>
                            <span class="badge bg-secondary">{{ ucfirst($alert->type ?? 'general') }}</span>
                        </td>
                        <td>
                            @php
                                $severityColors = ['low' => 'success', 'medium' => 'warning', 'high' => 'orange', 'critical' => 'danger'];
                                $severityColor = $severityColors[$alert->severity] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $severityColor }}">{{ ucfirst($alert->severity ?? 'medium') }}</span>
                        </td>
                        <td>
                            @if($alert->status == 'active')
                                <span class="badge bg-danger">
                                    <i class="bi bi-circle-fill me-1" style="font-size:0.5rem"></i>Active
                                </span>
                            @else
                                <span class="badge bg-success">Resolved</span>
                            @endif
                        </td>
                        <td>{{ $alert->createdBy->name ?? '-' }}</td>
                        <td>{{ $alert->created_at->format('d M Y H:i') }}</td>
                        <td>{{ $alert->resolved_at?->format('d M Y H:i') ?? '-' }}</td>
                        <td>
                            @if($alert->status == 'active')
                            <button type="button" class="btn btn-sm btn-success"
                                data-bs-toggle="modal" data-bs-target="#resolveModal{{ $alert->id }}">
                                <i class="bi bi-check-circle me-1"></i>Resolve
                            </button>
                            @else
                            <span class="text-muted small">Resolved</span>
                            @endif
                        </td>
                    </tr>

                    <!-- Resolve Modal -->
                    @if($alert->status == 'active')
                    <div class="modal fade" id="resolveModal{{ $alert->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title fw-semibold">Resolve Emergency Alert</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form method="POST" action="{{ route('admin.emergency.resolve', $alert) }}">
                                    @csrf @method('PATCH')
                                    <div class="modal-body">
                                        <p class="text-muted small mb-3">Resolving: <strong>{{ $alert->title }}</strong></p>
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">Resolution Notes</label>
                                            <textarea name="resolution_notes" class="form-control" rows="3"
                                                placeholder="Describe how the emergency was resolved..."></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="bi bi-check-circle me-2"></i>Mark as Resolved
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endif
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-5 text-muted">
                            <i class="bi bi-shield-check fs-1 d-block mb-2"></i>
                            No emergency alerts found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($alerts->hasMorePages())
=======
    @if($alerts->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $alerts->links() }}
    </div>
    @endif
</div>
@endsection
