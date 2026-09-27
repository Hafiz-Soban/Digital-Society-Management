@extends('layouts.admin')
@section('title', 'Maintenance Dashboard')
@section('page-title', 'Maintenance Management')

@section('content')
<div class="row g-4 mb-4">
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3">
                        <i class="bi bi-cash-stack fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Monthly Collection</h6>
                </div>
                <h3 class="fw-bold mb-0">PKR {{ number_format($stats['total_monthly_collection']) }}</h3>
                <p class="text-success small mb-0 mt-2">
                    <i class="bi bi-calendar-event me-1"></i>Current Month
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded-3 p-2 me-3">
                        <i class="bi bi-exclamation-triangle fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Outstanding Dues</h6>
                </div>
                <h3 class="fw-bold mb-0">PKR {{ number_format($stats['total_outstanding_dues']) }}</h3>
                <p class="text-danger small mb-0 mt-2">
                    Total unpaid maintenance
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3">
                        <i class="bi bi-piggy-bank fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Advance Balance</h6>
                </div>
                <h3 class="fw-bold mb-0">PKR {{ number_format($stats['total_advance_payments']) }}</h3>
                <p class="text-success small mb-0 mt-2">
                    Total resident credits
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3">
                        <i class="bi bi-people fs-4"></i>
                    </div>
                    <h6 class="mb-0 text-muted small">Defaulters</h6>
                </div>
                <h3 class="fw-bold mb-0">{{ number_format($stats['defaulters_count']) }}</h3>
                <p class="text-warning small mb-0 mt-2">
                    {{ $stats['high_dues_residents'] }} with dues > 10,000
                </p>
            </div>
        </div>
    </div>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-bold"><i class="bi bi-clock-history me-2 text-primary"></i>Recent Payments</h6>
        <a href="{{ route('admin.maintenance-management.payments') }}" class="btn btn-sm btn-outline-primary">View All</a>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Resident</th>
                        <th>House</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Method</th>
                        <th>Reference</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentPayments as $payment)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ $payment->resident->user->name }}</div>
                            <div class="small text-muted">{{ $payment->resident->resident_id }}</div>
                        </td>
                        <td>{{ $payment->house->house_number ?? 'N/A' }}</td>
                        <td class="fw-bold text-success">PKR {{ number_format($payment->amount) }}</td>
                        <td>{{ $payment->payment_date->format('d M Y') }}</td>
                        <td><span class="badge bg-info-subtle text-info">{{ ucfirst($payment->payment_method) }}</span></td>
                        <td><code>{{ $payment->reference_number ?? '-' }}</code></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No recent payments found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
