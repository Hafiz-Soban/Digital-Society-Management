@extends('layouts.admin')
@section('title', 'Resident Maintenance Records')
@section('page-title', 'Maintenance Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Resident Maintenance Records</h5>
        <p class="text-muted small mb-0">Overview of dues and balances for all residents</p>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.maintenance-management.records') }}" class="row g-2">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search resident or ID..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-primary w-100">Filter</button>
            </div>
        </form>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Resident</th>
                        <th>House</th>
                        <th>Current Due</th>
                        <th>Advance Balance</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $resident->user->name }}</div>
                            <div class="small text-muted">{{ $resident->resident_id }}</div>
                        </td>
                        <td>{{ $resident->house->house_number ?? 'N/A' }}</td>
                        <td class="{{ $resident->due_amount > 0 ? 'text-danger fw-bold' : '' }}">
                            PKR {{ number_format($resident->due_amount) }}
                        </td>
                        <td class="{{ $resident->advance_balance > 0 ? 'text-success fw-bold' : '' }}">
                            PKR {{ number_format($resident->advance_balance) }}
                        </td>
                        <td>
                            @if($resident->due_amount > 10000)
                                <span class="badge bg-danger">Defaulter (Restricted)</span>
                            @elseif($resident->due_amount > 0)
                                <span class="badge bg-warning text-dark">Dues Pending</span>
                            @elseif($resident->advance_balance > 0)
                                <span class="badge bg-success">Advance Paid</span>
                            @else
                                <span class="badge bg-info">Paid</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.maintenance-management.payments.create', ['resident_id' => $resident->id]) }}" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-plus-circle me-1"></i>Add Payment
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No resident records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($residents->hasMorePages())
    <div class="card-footer bg-white border-0">
        {{ $residents->links() }}
    </div>
    @endif
</div>
@endsection
