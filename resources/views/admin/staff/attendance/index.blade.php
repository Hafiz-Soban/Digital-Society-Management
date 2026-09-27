@extends('layouts.admin')

@section('title', 'Staff Attendance')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Staff Attendance</h2>
        <a href="{{ route('admin.staff.attendance.create') }}" class="btn btn-primary">
            <i class="bi bi-calendar-check me-2"></i>Mark Attendance
        </a>
    </div>

    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('admin.staff.attendance.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Date</label>
                    <input type="date" name="date" class="form-control" value="{{ request('date', now()->toDateString()) }}">
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Staff Member</label>
                    <select name="staff_id" class="form-select">
                        <option value="">All Staff</option>
                        @foreach($staffMembers as $staff)
                            <option value="{{ $staff->id }}" {{ request('staff_id') == $staff->id ? 'selected' : '' }}>{{ $staff->full_name }} ({{ $staff->employee_id }})</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Status</option>
                        <option value="present" {{ request('status') == 'present' ? 'selected' : '' }}>Present</option>
                        <option value="absent" {{ request('status') == 'absent' ? 'selected' : '' }}>Absent</option>
                        <option value="leave" {{ request('status') == 'leave' ? 'selected' : '' }}>Leave</option>
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-dark w-100">Filter Records</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Date</th>
                        <th>Employee ID</th>
                        <th>Name</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($attendance as $record)
                    <tr>
                        <td>{{ $record->date->format('d M, Y') }}</td>
                        <td><span class="fw-bold">{{ $record->staff->employee_id }}</span></td>
                        <td>{{ $record->staff->full_name }}</td>
                        <td>{{ $record->check_in ? date('h:i A', strtotime($record->check_in)) : '-' }}</td>
                        <td>{{ $record->check_out ? date('h:i A', strtotime($record->check_out)) : '-' }}</td>
                        <td>
                            @if($record->status == 'present')
                                <span class="badge bg-success">Present</span>
                            @elseif($record->status == 'absent')
                                <span class="badge bg-danger">Absent</span>
                            @else
                                <span class="badge bg-warning text-dark">Leave</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">No attendance records found for the selected criteria.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($attendance->hasPages())
        <div class="card-footer bg-white border-0">
            {{ $attendance->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
