@extends('layouts.admin')
@section('title', 'Vehicle Entry Logs')
@section('page-title', 'Vehicle Entry Logs')

@section('content')
<div class="row g-4">
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 100px;">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-shield-check me-2 text-primary"></i>Record Vehicle Entry</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicles.logs.store') }}" method="POST" id="entryForm">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vehicle Number</label>
                        <div class="input-group">
                            <input type="text" name="vehicle_number" id="vehicle_number" class="form-control" required placeholder="ABC-1234" autocomplete="off">
                            <button class="btn btn-outline-primary" type="button" id="verifyBtn">Verify</button>
                        </div>
                        <div id="verifyResult" class="mt-2 small"></div>
                    </div>

                    <div id="verifiedInfo" class="mb-3 d-none p-3 bg-success bg-opacity-10 border border-success border-opacity-25 rounded-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-check-circle-fill text-success"></i>
                            <span class="fw-bold text-success">Verified Vehicle</span>
                        </div>
                        <div class="small">
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">House:</span>
                                <span class="fw-semibold" id="v_house"></span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Owner:</span>
                                <span class="fw-semibold" id="v_owner"></span>
                            </div>
                            <div class="d-flex justify-content-between mb-1">
                                <span class="text-muted">Type:</span>
                                <span class="fw-semibold" id="v_type"></span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span class="text-muted">Sticker:</span>
                                <span class="fw-semibold" id="v_sticker"></span>
                            </div>
                        </div>
                    </div>

                    <div id="unknownInfo" class="mb-3 d-none p-3 bg-warning bg-opacity-10 border border-warning border-opacity-25 rounded-3">
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <i class="bi bi-question-circle-fill text-warning"></i>
                            <span class="fw-bold text-warning">Unknown Vehicle</span>
                        </div>
                        <p class="small mb-0 text-muted">Registering as an unknown vehicle entry. A security alert will be generated.</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Driver Name (Optional)</label>
                        <input type="text" name="driver_name" class="form-control" placeholder="Enter driver name">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Visiting House (Optional)</label>
                        <select name="house_id" class="form-select">
                            <option value="">Unknown / General</option>
                            @foreach(\App\Models\House::all() as $house)
                                <option value="{{ $house->id }}">{{ $house->house_number }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Record Entry</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold"><i class="bi bi-list-task me-2 text-primary"></i>Entry History</h6>
                <form action="{{ route('admin.vehicles.logs.index') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Search vehicle..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-primary">Search</button>
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Vehicle #</th>
                                <th>Status</th>
                                <th>House</th>
                                <th>Entry</th>
                                <th>Exit</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($logs as $log)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{ $log->vehicle_number }}</span>
                                    @if($log->driver_name)
                                        <div class="small text-muted">{{ $log->driver_name }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($log->entry_status == 'verified')
                                        <span class="badge bg-success">Verified</span>
                                    @elseif($log->entry_status == 'suspicious')
                                        <span class="badge bg-danger">Suspicious</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Unknown</span>
                                    @endif
                                </td>
                                <td>{{ $log->house->house_number ?? '-' }}</td>
                                <td>{{ $log->entry_time->format('h:i A') }}<br><small class="text-muted">{{ $log->entry_time->format('d M') }}</small></td>
                                <td>
                                    @if($log->exit_time)
                                        {{ $log->exit_time->format('h:i A') }}<br><small class="text-muted">{{ $log->exit_time->format('d M') }}</small>
                                    @else
                                        <span class="text-danger small">Inside</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        @if(!$log->exit_time)
                                            <form action="{{ route('admin.vehicles.logs.exit', $log) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-outline-danger">Record Exit</button>
                                            </form>
                                        @endif
                                        
                                        <a href="{{ route('admin.vehicles.logs.edit', $log) }}" class="btn btn-sm btn-outline-primary">
                                             <i class="bi bi-pencil"></i> Edit
                                         </a>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">No entry logs found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            @if($logs->hasMorePages())
            <div class="card-footer bg-white border-0">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('verifyBtn').addEventListener('click', function() {
        const vehicleNumber = document.getElementById('vehicle_number').value;
        const verifiedInfo = document.getElementById('verifiedInfo');
        const unknownInfo = document.getElementById('unknownInfo');
        const verifyResult = document.getElementById('verifyResult');

        if (!vehicleNumber) return;

        verifyResult.innerHTML = '<span class="text-primary"><i class="bi bi-hourglass-split me-1"></i>Verifying...</span>';
        
        fetch(`/admin/vehicles/verify/${vehicleNumber}`)
            .then(response => response.json())
            .then(data => {
                verifyResult.innerHTML = '';
                if (data.status === 'verified') {
                    verifiedInfo.classList.remove('d-none');
                    unknownInfo.classList.add('d-none');
                    document.getElementById('v_house').innerText = data.house_number;
                    document.getElementById('v_owner').innerText = data.owner_name;
                    document.getElementById('v_type').innerText = data.vehicle_type;
                    document.getElementById('v_sticker').innerText = data.sticker_number;
                } else {
                    verifiedInfo.classList.add('d-none');
                    unknownInfo.classList.remove('d-none');
                }
            })
            .catch(error => {
                verifyResult.innerHTML = '<span class="text-danger">Error verifying vehicle</span>';
            });
    });
</script>
@endpush
@endsection
