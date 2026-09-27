@extends('layouts.admin')

@section('title', 'Record Salary')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.staff-salaries.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Salaries
        </a>
        <h2 class="h4">Record Salary Payment</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.staff-salaries.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Staff Member</label>
                            <select name="staff_id" id="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required onchange="updateSalary()">
                                <option value="">Choose Staff...</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}" data-salary="{{ $staff->salary }}">{{ $staff->full_name }} ({{ $staff->employee_id }})</option>
                                @endforeach
                            </select>
                            @error('staff_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Month</label>
                            <input type="text" name="month" class="form-control" value="{{ date('F Y') }}" required>
                            <small class="text-muted">Format: Month Year (e.g. June 2026)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Salary Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" name="amount" id="salary_amount" class="form-control @error('amount') is-invalid @enderror" required>
                            </div>
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Payment Date</label>
                            <input type="date" name="payment_date" class="form-control" value="{{ date('Y-m-d') }}">
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Payment Status</label>
                            <select name="status" class="form-select">
                                <option value="pending">Pending</option>
                                <option value="paid" selected>Paid</option>
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save Salary Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function updateSalary() {
    const select = document.getElementById('staff_id');
    const amountInput = document.getElementById('salary_amount');
    const selectedOption = select.options[select.selectedIndex];
    
    if (selectedOption.value) {
        amountInput.value = selectedOption.getAttribute('data-salary');
    } else {
        amountInput.value = '';
    }
}
</script>
@endsection
