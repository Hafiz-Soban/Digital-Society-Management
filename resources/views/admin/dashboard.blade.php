@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<<<<<<< HEAD
<!-- Maintenance Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-primary bg-opacity-10">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-20 p-2">
                    <i class="bi bi-cash-stack text-primary fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-primary">PKR {{ number_format($stats['maintenance_collection']) }}</div>
                    <div class="text-muted small">Monthly Collection</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-danger bg-opacity-10">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-20 p-2">
                    <i class="bi bi-exclamation-circle text-danger fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-danger">PKR {{ number_format($stats['maintenance_dues']) }}</div>
                    <div class="text-muted small">Total Dues</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-success bg-opacity-10">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-20 p-2">
                    <i class="bi bi-piggy-bank text-success fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-success">PKR {{ number_format($stats['maintenance_advance']) }}</div>
                    <div class="text-muted small">Total Advance</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3 border-0 shadow-sm bg-warning bg-opacity-10">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-20 p-2">
                    <i class="bi bi-people text-warning fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold text-warning">{{ $stats['maintenance_high_dues'] }}</div>
                    <div class="text-muted small">High Dues (>10k)</div>
                </div>
            </div>
        </div>
    </div>
</div>

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
<!-- Stats Row -->
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card stat-card bg-primary text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['total_residents'] }}</div>
                    <div class="stat-label text-white-50">Total Residents</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-people text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:0.75rem; opacity:0.8">
                <i class="bi bi-arrow-up-short"></i> Active residents
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card bg-success text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['occupied_houses'] }}</div>
                    <div class="stat-label text-white-50">Occupied Houses</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-house-check text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:0.75rem; opacity:0.8">
                {{ $stats['vacant_houses'] }} vacant
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card bg-warning text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['open_complaints'] }}</div>
                    <div class="stat-label text-white-50">Open Complaints</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-chat-square-text text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:0.75rem; opacity:0.8">
                {{ $stats['total_complaints'] }} total
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card stat-card bg-danger text-white">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <div class="stat-value">{{ $stats['active_alerts'] }}</div>
                    <div class="stat-label text-white-50">Active Alerts</div>
                </div>
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-exclamation-triangle text-white"></i>
                </div>
            </div>
            <div class="mt-2" style="font-size:0.75rem; opacity:0.8">
                Emergency alerts
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-info bg-opacity-10 p-3">
                    <i class="bi bi-person-badge text-info fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $stats['total_visitors_today'] }}</div>
                    <div class="text-muted small">Visitors Today</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-warning bg-opacity-10 p-3">
                    <i class="bi bi-tools text-warning fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $stats['pending_maintenance'] }}</div>
                    <div class="text-muted small">Pending Maintenance</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-primary bg-opacity-10 p-3">
                    <i class="bi bi-house text-primary fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $stats['total_houses'] }}</div>
                    <div class="text-muted small">Total Houses</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-success bg-opacity-10 p-3">
                    <i class="bi bi-people text-success fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $stats['total_users'] }}</div>
                    <div class="text-muted small">Total Users</div>
                </div>
            </div>
        </div>
    </div>
<<<<<<< HEAD
=======
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-danger bg-opacity-10 p-3">
                    <i class="bi bi-wallet2 text-danger fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">Rs. {{ number_format($stats['total_expenses_month']) }}</div>
                    <div class="text-muted small">Monthly Expenses</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card p-3">
            <div class="d-flex align-items-center gap-3">
                <div class="rounded-circle bg-dark bg-opacity-10 p-3">
                    <i class="bi bi-person-badge-fill text-dark fs-5"></i>
                </div>
                <div>
                    <div class="fw-bold fs-5">{{ $stats['total_staff'] }}</div>
                    <div class="text-muted small">Active Staff</div>
                </div>
            </div>
        </div>
    </div>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
</div>

<!-- Charts Row -->
<div class="row g-3 mb-4">
    <div class="col-md-8">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Complaints Overview (Last 6 Months)</h6>
            <canvas id="complaintsChart" height="100"></canvas>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card p-4">
            <h6 class="fw-semibold mb-3">Complaint Status</h6>
            <canvas id="statusChart" height="200"></canvas>
        </div>
    </div>
</div>

<!-- Active Alerts -->
@if($activeAlerts->count() > 0)
<div class="alert alert-danger d-flex align-items-start gap-3 mb-4">
    <i class="bi bi-exclamation-triangle-fill fs-4 mt-1"></i>
    <div>
        <strong>Active Emergency Alerts</strong>
        @foreach($activeAlerts as $alert)
            <div class="mt-1">
                <span class="badge bg-danger me-1">{{ strtoupper($alert->type) }}</span>
                {{ $alert->title }} - <small>{{ $alert->created_at->diffForHumans() }}</small>
            </div>
        @endforeach
        <a href="{{ route('admin.emergency.index') }}" class="btn btn-sm btn-danger mt-2">Manage Alerts</a>
    </div>
</div>
@endif

<!-- Recent Activities -->
<div class="row g-3">
    <!-- Recent Complaints -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">Recent Complaints</h6>
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Complaint</th>
                                <th>Resident</th>
                                <th>Priority</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentComplaints as $complaint)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="text-decoration-none fw-semibold">
                                        {{ $complaint->complaint_number }}
                                    </a>
                                    <div class="text-muted small">{{ Str::limit($complaint->title, 30) }}</div>
                                </td>
                                <td>{{ $complaint->resident->user->name ?? 'N/A' }}</td>
                                <td>{!! $complaint->priority_badge !!}</td>
                                <td>{!! $complaint->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No complaints yet</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Visitors -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">Recent Visitors</h6>
                <a href="{{ route('admin.visitors.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Visitor</th>
                                <th>Resident</th>
                                <th>Purpose</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentVisitors as $visitor)
                            <tr>
                                <td>
                                    <div class="fw-semibold">{{ $visitor->visitor_name }}</div>
                                    <div class="text-muted small">{{ $visitor->visitor_phone }}</div>
                                </td>
                                <td>{{ $visitor->resident->user->name ?? 'N/A' }}</td>
                                <td>{{ Str::limit($visitor->purpose, 20) }}</td>
                                <td>{!! $visitor->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No visitors today</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Maintenance -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">Recent Maintenance Requests</h6>
                <a href="{{ route('admin.maintenance.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Request</th>
                                <th>House</th>
                                <th>Category</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMaintenance as $req)
                            <tr>
                                <td>
                                    <a href="{{ route('admin.maintenance.show', $req) }}" class="text-decoration-none fw-semibold">
                                        {{ $req->request_number }}
                                    </a>
                                    <div class="text-muted small">{{ Str::limit($req->title, 25) }}</div>
                                </td>
                                <td>{{ $req->house->house_number ?? 'N/A' }}</td>
                                <td><span class="badge bg-secondary">{{ ucfirst($req->category) }}</span></td>
                                <td>{!! $req->status_badge !!}</td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-3">No requests</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Latest Notices -->
    <div class="col-md-6">
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">Latest Notices</h6>
                <a href="{{ route('admin.notices.index') }}" class="btn btn-sm btn-outline-primary">View All</a>
            </div>
            <div class="card-body">
                @forelse($latestNotices as $notice)
                <div class="d-flex gap-3 mb-3 pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                    <div class="rounded-circle bg-primary bg-opacity-10 p-2 flex-shrink-0" style="width:40px;height:40px;display:flex;align-items:center;justify-content:center">
                        <i class="bi bi-megaphone text-primary"></i>
                    </div>
                    <div>
                        <div class="fw-semibold" style="font-size:0.875rem">{{ $notice->title }}</div>
                        <div class="text-muted small">{{ $notice->created_at->diffForHumans() }}</div>
                        <div class="mt-1">{!! $notice->type_badge !!}</div>
                    </div>
                </div>
                @empty
                <div class="text-center text-muted py-3">No notices published</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Complaints Chart
const complaintsData = @json($complaintsChart);
const months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];

new Chart(document.getElementById('complaintsChart'), {
    type: 'bar',
    data: {
        labels: complaintsData.map(d => months[d.month - 1] + ' ' + d.year),
        datasets: [{
            label: 'Complaints',
            data: complaintsData.map(d => d.count),
            backgroundColor: 'rgba(13, 110, 253, 0.7)',
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
    }
});

// Status Doughnut Chart
const statusData = @json($complaintStatus);
<<<<<<< HEAD
const statusColors = { pending: '#dc3545', in_progress: '#ffc107', resolved: '#198754', closed: '#6c757d', escalated: '#212529' };
=======
const statusColors = { open: '#dc3545', in_progress: '#ffc107', resolved: '#198754', closed: '#6c757d', escalated: '#212529' };
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

new Chart(document.getElementById('statusChart'), {
    type: 'doughnut',
    data: {
        labels: statusData.map(d => d.status.replace('_', ' ').toUpperCase()),
        datasets: [{
            data: statusData.map(d => d.count),
            backgroundColor: statusData.map(d => statusColors[d.status] || '#adb5bd'),
            borderWidth: 2,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom', labels: { font: { size: 11 } } }
        },
        cutout: '65%'
    }
});
</script>
@endpush
