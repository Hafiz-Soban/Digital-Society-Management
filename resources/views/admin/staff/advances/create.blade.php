@extends('layouts.admin')

@section('title', 'Give Advance')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.staff-advances.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Advances
        </a>
        <h2 class="h4">Give Salary Advance</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.staff-advances.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Select Staff Member</label>
                            <select name="staff_id" class="form-select @error('staff_id') is-invalid @enderror" required>
                                <option value="">Choose Staff...</option>
                                @foreach($staffMembers as $staff)
                                    <option value="{{ $staff->id }}">{{ $staff->full_name }} ({{ $staff->employee_id }})</option>
                                @endforeach
                            </select>
                            @error('staff_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Advance Amount</label>
                            <div class="input-group">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror" required>
                            </div>
                            @error('amount') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" name="advance_date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Reason</label>
                            <input type="text" name="reason" class="form-control @error('reason') is-invalid @enderror" placeholder="e.g. Medical emergency, Family event" required>
                            @error('reason') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Additional Notes (Optional)</label>
                            <textarea name="notes" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Approve & Record Advance</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
