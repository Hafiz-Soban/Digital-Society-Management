@extends('layouts.admin')
@section('title', 'Maintenance Payment History')
@section('page-title', 'Maintenance Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Maintenance Payment History</h5>
        <p class="text-muted small mb-0">Record of all maintenance payments received</p>
    </div>
    <a href="{{ route('admin.maintenance-management.payments.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-lg me-2"></i>Add Payment
    </a>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-header bg-white py-3">
        <form method="GET" action="{{ route('admin.maintenance-management.payments') }}" class="row g-2">
            <div class="col-md-4">
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control border-start-0" placeholder="Search resident or reference..." value="{{ request('search') }}">
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
                        <th>Date</th>
                        <th>Resident</th>
                        <th>House</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Reference</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                    <tr>
                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                        <td>
                            <div class="fw-semibold">{{ $payment->resident->user->name }}</div>
                            <div class="small text-muted">{{ $payment->resident->resident_id }}</div>
                        </td>
                        <td>{{ $payment->house->house_number ?? 'N/A' }}</td>
                        <td class="fw-bold text-success">PKR {{ number_format($payment->amount) }}</td>
                        <td><span class="badge bg-info-subtle text-info">{{ ucfirst($payment->payment_method) }}</span></td>
                        <td><code>{{ $payment->reference_number ?? '-' }}</code></td>
                        <td><small class="text-muted">{{ Str::limit($payment->notes, 30) }}</small></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted">No payment records found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @if($payments->hasMorePages())
    <div class="card-footer bg-white border-0">
        {{ $payments->links() }}
    </div>
    @endif
</div>
@endsection
