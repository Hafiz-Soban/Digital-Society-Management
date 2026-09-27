@extends('layouts.admin')
@section('title', 'Residents Report')
@section('page-title', 'Residents Report')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Residents Report</h5>
        <p class="text-muted small mb-0">Detailed resident analysis and statistics</p>
    </div>
    <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Reports
    </a>
</div>

<!-- Filter Form -->
<div class="card mb-4">
    <div class="card-header bg-white py-3">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-funnel me-2"></i>Filter Report</h6>
    </div>
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-3">
                <label class="form-label fw-semibold">Status</label>
                <select name="status" class="form-select">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="moved_out" {{ request('status') == 'moved_out' ? 'selected' : '' }}>Moved Out</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label fw-semibold">Ownership Type</label>
                <select name="ownership_type" class="form-select">
                    <option value="">All Types</option>
                    <option value="owner" {{ request('ownership_type') == 'owner' ? 'selected' : '' }}>Owner</option>
                    <option value="tenant" {{ request('ownership_type') == 'tenant' ? 'selected' : '' }}>Tenant</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">From Date</label>
                <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label fw-semibold">To Date</label>
                <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
            </div>
            <div class="col-md-2 d-flex align-items-end gap-2">
                <button type="submit" class="btn btn-primary flex-fill">Generate</button>
                <a href="{{ route('admin.reports.residents') }}" class="btn btn-outline-secondary">Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Stats Summary -->
<div class="row g-3 mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-primary text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-people text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Total Residents</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-success text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-person-check text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['active'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Active</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-info text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-house text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['owners'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Owners</div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-6 col-xl-3">
        <div class="card stat-card bg-warning text-white">
            <div class="card-body d-flex align-items-center gap-3">
                <div class="stat-icon bg-white bg-opacity-25">
                    <i class="bi bi-key text-white"></i>
                </div>
                <div>
                    <div class="stat-value">{{ $stats['tenants'] ?? 0 }}</div>
                    <div class="stat-label text-white-50">Tenants</div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Results Table -->
<div class="card">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold">Results</h6>
        <span class="badge bg-secondary">{{ $residents->total() }} records</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Resident</th>
                        <th>Resident ID</th>
                        <th>House</th>
                        <th>Type</th>
                        <th>Move In</th>
                        <th>Move Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $resident->user->name }}</div>
                            <div class="text-muted small">{{ $resident->user->email }}</div>
                        </td>
                        <td><code>{{ $resident->resident_id }}</code></td>
                        <td>{{ $resident->house->house_number ?? '-' }}</td>
                        <td>
                            <span class="badge {{ $resident->ownership_type == 'owner' ? 'bg-primary' : 'bg-info' }}">
                                {{ ucfirst($resident->ownership_type) }}
                            </span>
                        </td>
                        <td>{{ $resident->move_in_date?->format('d M Y') ?? '-' }}</td>
                        <td>{{ $resident->move_out_date?->format('d M Y') ?? '-' }}</td>
                        <td>{!! $resident->status_badge !!}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">
                            <i class="bi bi-people fs-1 d-block mb-2"></i>
                            No residents match the selected filters
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($residents->hasMorePages())
=======
    @if($residents->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $residents->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
