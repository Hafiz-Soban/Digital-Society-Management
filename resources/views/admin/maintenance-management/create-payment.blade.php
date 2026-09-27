@extends('layouts.admin')
@section('title', 'Add Maintenance Payment')
@section('page-title', 'Maintenance Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-cash-coin me-2 text-primary"></i>Record Maintenance Payment</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.maintenance-management.payments.store') }}" method="POST">
                    @csrf
                    
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Resident <span class="text-danger">*</span></label>
                            <select name="resident_id" id="resident_id" class="form-select @error('resident_id') is-invalid @enderror" required>
                                <option value="">Select Resident</option>
                                @foreach($residents as $resident)
                                    <option value="{{ $resident->id }}" 
                                        {{ (old('resident_id') == $resident->id || request('resident_id') == $resident->id) ? 'selected' : '' }}
                                        data-house="{{ $resident->house->house_number ?? 'N/A' }}"
                                        data-due="{{ $resident->due_amount }}"
                                        data-advance="{{ $resident->advance_balance }}">
                                        {{ $resident->user->name }} ({{ $resident->resident_id }}) - {{ $resident->house->house_number ?? 'No House' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('resident_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">House Number</label>
                            <input type="text" id="house_number_display" class="form-control bg-light" readonly placeholder="Auto-filled">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Current Balance Info</label>
                            <div id="balance_info" class="p-2 border rounded bg-light small">
                                Select a resident to see balance
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Amount Paid (PKR) <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">PKR</span>
                                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" value="{{ old('amount') }}" required min="1">
                            </div>
                            @error('amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Date <span class="text-danger">*</span></label>
                            <input type="date" name="payment_date" class="form-control @error('payment_date') is-invalid @enderror" value="{{ old('payment_date', date('Y-m-d')) }}" required>
                            @error('payment_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Payment Method <span class="text-danger">*</span></label>
                            <select name="payment_method" class="form-select @error('payment_method') is-invalid @enderror" required>
                                <option value="cash" {{ old('payment_method') == 'cash' ? 'selected' : '' }}>Cash</option>
                                <option value="bank_transfer" {{ old('payment_method') == 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                <option value="cheque" {{ old('payment_method') == 'cheque' ? 'selected' : '' }}>Cheque</option>
                                <option value="online" {{ old('payment_method') == 'online' ? 'selected' : '' }}>Online Payment</option>
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Reference Number</label>
                            <input type="text" name="reference_number" class="form-control @error('reference_number') is-invalid @enderror" value="{{ old('reference_number') }}" placeholder="Transaction ID, Cheque No, etc.">
                            @error('reference_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-semibold">Notes</label>
                            <textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea>
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.maintenance-management.payments') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Record Payment
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const residentSelect = document.getElementById('resident_id');
        const houseDisplay = document.getElementById('house_number_display');
        const balanceInfo = document.getElementById('balance_info');

        function updateResidentInfo() {
            const selected = residentSelect.options[residentSelect.selectedIndex];
            if (selected && selected.value) {
                const house = selected.getAttribute('data-house');
                const due = selected.getAttribute('data-due');
                const advance = selected.getAttribute('data-advance');
                
                houseDisplay.value = house;
                balanceInfo.innerHTML = `
                    <div class="d-flex justify-content-between">
                        <span>Due Amount:</span>
                        <span class="text-danger fw-bold">PKR ${new Number(due).toLocaleString()}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Advance Balance:</span>
                        <span class="text-success fw-bold">PKR ${new Number(advance).toLocaleString()}</span>
                    </div>
                `;
            } else {
                houseDisplay.value = '';
                balanceInfo.innerHTML = 'Select a resident to see balance';
            }
        }

        residentSelect.addEventListener('change', updateResidentInfo);
        updateResidentInfo(); // Run on load
    });
</script>
@endpush
@endsection
