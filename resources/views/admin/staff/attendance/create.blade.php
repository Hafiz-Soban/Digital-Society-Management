@extends('layouts.admin')

@section('title', 'Mark Attendance')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.staff.attendance.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Attendance
        </a>
        <h2 class="h4">Mark Staff Attendance</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.staff.attendance.store') }}" method="POST">
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
                            <label class="form-label">Date</label>
                            <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Check In Time</label>
                                <input type="time" name="check_in" class="form-control" value="09:00">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Check Out Time</label>
                                <input type="time" name="check_out" class="form-control" value="18:00">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-block">Status</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="present" value="present" checked>
                                <label class="form-check-label" for="present">Present</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="absent" value="absent">
                                <label class="form-check-label" for="absent">Absent</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" name="status" id="leave" value="leave">
                                <label class="form-check-label" for="leave">Leave</label>
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save Attendance Record</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
