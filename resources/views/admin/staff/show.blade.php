@extends('layouts.admin')

@section('title', 'Staff Profile')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.staff.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
                <i class="bi bi-arrow-left me-1"></i>Back to List
            </a>
            <h2 class="h4 mb-0">Staff Profile: {{ $staff->full_name }}</h2>
        </div>
        <div>
            <a href="{{ route('admin.staff.edit', $staff) }}" class="btn btn-primary">
                <i class="bi bi-pencil me-2"></i>Edit Profile
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Sidebar Info -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm mb-4 text-center p-4">
                <div class="mb-3">
                    @if($staff->photo_path)
                        <img src="{{ asset('storage/' . $staff->photo_path) }}" class="rounded-circle border" width="120" height="120" style="object-fit: cover;">
                    @else
                        <div class="rounded-circle bg-light d-inline-flex align-items-center justify-content-center border" style="width: 120px; height: 120px;">
                            <i class="bi bi-person text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                </div>
                <h3 class="h5 mb-1">{{ $staff->full_name }}</h3>
                <p class="text-muted mb-2">{{ $staff->designation }}</p>
                <div class="mb-3">
                    @if($staff->status == 'active')
                        <span class="badge bg-success-subtle text-success px-3">Active</span>
                    @else
                        <span class="badge bg-danger-subtle text-danger px-3">Inactive</span>
                    @endif
                </div>
                <hr>
                <div class="row text-start g-3">
                    <div class="col-12">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Employee ID</small>
                        <span>{{ $staff->employee_id }}</span>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Phone</small>
                        <span>{{ $staff->phone_number }}</span>
                    </div>
                    <div class="col-12">
                        <small class="text-muted d-block text-uppercase fw-bold" style="font-size: 0.7rem;">Email</small>
                        <span>{{ $staff->email ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <!-- Salary Summary Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Salary Summary</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Monthly Salary:</span>
                        <span class="fw-bold">Rs. {{ number_format($staff->salary, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Total Advances Taken:</span>
                        <span class="fw-bold text-danger">- Rs. {{ number_format($staff->advances->sum('amount'), 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="fw-bold">Remaining Balance:</span>
                        <span class="fw-bold text-success">Rs. {{ number_format($staff->salary - $staff->advances->sum('amount'), 2) }}</span>
                    </div>
                </div>
            </div>

            <!-- Emergency Contact Card -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="card-title mb-0">Emergency Contact</h5>
                </div>
                <div class="card-body pt-0">
                    <div class="mb-2">
                        <small class="text-muted d-block">Name</small>
                        <span class="fw-medium">{{ $staff->emergency_name }}</span>
                    </div>
                    <div class="mb-2">
                        <small class="text-muted d-block">Number</small>
                        <span class="fw-medium">{{ $staff->emergency_phone }}</span>
                    </div>
                    <div>
                        <small class="text-muted d-block">Relationship</small>
                        <span class="fw-medium">{{ $staff->emergency_relation }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <ul class="nav nav-tabs card-header-tabs border-0" id="profileTabs" role="tablist">
                        <li class="nav-item">
                            <button class="nav-link active" id="details-tab" data-bs-toggle="tab" data-bs-target="#details" type="button" role="tab">Personal Info</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="attendance-tab" data-bs-toggle="tab" data-bs-target="#attendance" type="button" role="tab">Recent Attendance</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="salary-tab" data-bs-toggle="tab" data-bs-target="#salary" type="button" role="tab">Salary History</button>
                        </li>
                        <li class="nav-item">
                            <button class="nav-link" id="advances-tab" data-bs-toggle="tab" data-bs-target="#advances" type="button" role="tab">Advance History</button>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="profileTabsContent">
                        <!-- Details Tab -->
                        <div class="tab-pane fade show active" id="details" role="tabpanel">
                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Father Name</label>
                                    <span class="fw-medium">{{ $staff->father_name }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">CNIC Number</label>
                                    <span class="fw-medium">{{ $staff->cnic }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Date of Birth</label>
                                    <span class="fw-medium">{{ $staff->dob->format('d M, Y') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Gender</label>
                                    <span class="fw-medium text-capitalize">{{ $staff->gender }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block">Address</label>
                                    <span class="fw-medium">{{ $staff->address }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Joining Date</label>
                                    <span class="fw-medium">{{ $staff->joining_date->format('d M, Y') }}</span>
                                </div>
                                <div class="col-md-6">
                                    <label class="text-muted small d-block">Shift Timing</label>
                                    <span class="fw-medium">{{ $staff->shift_timing }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Attendance Tab -->
                        <div class="tab-pane fade" id="attendance" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>In</th>
                                            <th>Out</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staff->attendance as $att)
                                        <tr>
                                            <td>{{ $att->date->format('d M, Y') }}</td>
                                            <td>{{ $att->check_in ? date('h:i A', strtotime($att->check_in)) : '-' }}</td>
                                            <td>{{ $att->check_out ? date('h:i A', strtotime($att->check_out)) : '-' }}</td>
                                            <td>
                                                @if($att->status == 'present')
                                                    <span class="badge bg-success">Present</span>
                                                @elseif($att->status == 'absent')
                                                    <span class="badge bg-danger">Absent</span>
                                                @else
                                                    <span class="badge bg-warning">Leave</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted">No recent attendance found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Salary History -->
                        <div class="tab-pane fade" id="salary" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Month</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staff->salaries as $sal)
                                        <tr>
                                            <td>{{ $sal->month }}</td>
                                            <td>Rs. {{ number_format($sal->amount, 2) }}</td>
                                            <td>{{ $sal->payment_date ? $sal->payment_date->format('d M, Y') : '-' }}</td>
                                            <td>
                                                @if($sal->status == 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-3 text-muted">No salary records found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Advance History -->
                        <div class="tab-pane fade" id="advances" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-sm">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Amount</th>
                                            <th>Reason</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($staff->advances as $adv)
                                        <tr>
                                            <td>{{ $adv->advance_date->format('d M, Y') }}</td>
                                            <td class="text-danger fw-bold">Rs. {{ number_format($adv->amount, 2) }}</td>
                                            <td>{{ $adv->reason }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="3" class="text-center py-3 text-muted">No advance salary history found.</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
