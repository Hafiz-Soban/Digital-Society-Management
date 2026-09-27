@extends('layouts.resident')
@section('title','Staff Details')
@section('page-title','Domestic Staff Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $staffMember->name }}</h5>
        <p class="text-muted small mb-0">{{ $staffTypes[$staffMember->staff_type] ?? ucfirst(str_replace('_',' ',$staffMember->staff_type)) }}</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('resident.domestic-staff.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back
        </a>
        <a href="{{ route('resident.domestic-staff.edit', $staffMember->id) }}" class="btn btn-primary">
            <i class="bi bi-pencil me-2"></i>Edit
        </a>
    </div>
</div>

<div class="row g-4">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-badge me-2 text-primary"></i>Profile</h6>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-start gap-3">
                    <div class="rounded border bg-light" style="width:84px;height:84px;overflow:hidden;flex-shrink:0">
                        @if($staffMember->profile_photo_path)
                            <img src="{{ asset('storage/' . $staffMember->profile_photo_path) }}" alt="Photo" style="width:100%;height:100%;object-fit:cover">
                        @else
                            <div class="h-100 w-100 d-flex align-items-center justify-content-center text-muted">
                                <i class="bi bi-person fs-2"></i>
                            </div>
                        @endif
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex align-items-center gap-2 flex-wrap">
                            <div class="fw-bold fs-5">{{ $staffMember->name }}</div>
                            <div>{!! $staffMember->status_badge !!}</div>
                        </div>
                        <div class="text-muted small mt-1">
                            Joined: {{ $staffMember->joining_date ? $staffMember->joining_date->format('d M Y') : '—' }}
                        </div>
                    </div>
                </div>

                <div class="row g-3 mt-3">
                    <div class="col-md-6">
                        <div class="small text-muted">CNIC</div>
                        <div class="fw-semibold">{{ $staffMember->cnic ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Mobile</div>
                        <div class="fw-semibold">{{ $staffMember->mobile ?? '—' }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Staff Type</div>
                        <div class="fw-semibold">{{ $staffTypes[$staffMember->staff_type] ?? ucfirst(str_replace('_',' ',$staffMember->staff_type)) }}</div>
                    </div>
                    <div class="col-md-6">
                        <div class="small text-muted">Emergency Contact</div>
                        <div class="fw-semibold">{{ $staffMember->emergency_contact ?? '—' }}</div>
                    </div>
                    <div class="col-12">
                        <div class="small text-muted">Address</div>
                        <div class="fw-semibold">{{ $staffMember->address ?: '—' }}</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-calendar-check me-2 text-primary"></i>Attendance</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.domestic-staff.attendance.store', $staffMember->id) }}" class="row g-2 align-items-end">
                    @csrf
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold mb-1">Date</label>
                        <input type="date" name="attendance_date" class="form-control" value="{{ old('attendance_date', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold mb-1">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="present" {{ old('status') === 'present' ? 'selected' : '' }}>Present</option>
                            <option value="absent" {{ old('status') === 'absent' ? 'selected' : '' }}>Absent</option>
                            <option value="leave" {{ old('status') === 'leave' ? 'selected' : '' }}>Leave</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1">Check-in</label>
                        <input type="time" name="check_in_time" class="form-control" value="{{ old('check_in_time') }}">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label small fw-semibold mb-1">Check-out</label>
                        <input type="time" name="check_out_time" class="form-control" value="{{ old('check_out_time') }}">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-plus-lg me-1"></i>Save
                        </button>
                    </div>
                </form>

                <div class="table-responsive mt-3">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($attendances as $row)
                                <tr>
                                    <td class="fw-semibold">{{ $row->attendance_date?->format('d M Y') }}</td>
                                    <td>{!! $row->status_badge !!}</td>
                                    <td>{{ $row->check_in_time ?? '—' }}</td>
                                    <td>{{ $row->check_out_time ?? '—' }}</td>
                                    <td class="text-end">
                                        <form method="POST" action="{{ route('resident.domestic-staff.attendance.destroy', [$staffMember->id, $row->id]) }}"
                                              onsubmit="return confirm('Delete this attendance record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        No attendance records yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($attendances->hasPages())
                    <div class="mt-3">{{ $attendances->links() }}</div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-5">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-qr-code me-2 text-primary"></i>QR Code</h6>
            </div>
            <div class="card-body text-center">
                <img src="{{ route('resident.domestic-staff.qr.image', $staffMember->id) }}"
                     alt="QR Code" class="img-fluid border rounded p-2" style="max-width:280px;background:#fff">

                <div class="d-flex gap-2 justify-content-center mt-3 flex-wrap">
                    <a href="{{ route('resident.domestic-staff.qr.download', $staffMember->id) }}" class="btn btn-outline-primary">
                        <i class="bi bi-download me-2"></i>Download
                    </a>
                    <a href="{{ route('resident.domestic-staff.qr.print', $staffMember->id) }}" class="btn btn-outline-secondary" target="_blank">
                        <i class="bi bi-printer me-2"></i>Print
                    </a>
                </div>

                <div class="alert alert-info mt-3 mb-0 d-flex gap-2 text-start" style="font-size:.82rem">
                    <i class="bi bi-info-circle-fill flex-shrink-0 mt-1"></i>
                    <span>This QR code is unique per staff member. Re-downloading or printing always uses the same code.</span>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-shield-check me-2 text-primary"></i>Actions</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.domestic-staff.destroy', $staffMember->id) }}"
                      onsubmit="return confirm('Delete this staff member?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger w-100">
                        <i class="bi bi-trash me-2"></i>Delete Staff
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

