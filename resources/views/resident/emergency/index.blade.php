@extends('layouts.resident')
@section('title', 'Emergency Services')
@section('page-title', 'Emergency Services')

@section('content')
<div class="row g-4">
    {{-- SOS Button Card --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm bg-danger text-white mb-4">
            <div class="card-body p-4 text-center">
                <div class="mb-3">
                    <i class="bi bi-exclamation-octagon-fill display-1"></i>
                </div>
                <h3 class="fw-bold mb-2">SOS ALERT</h3>
                <p class="mb-4 opacity-75">Press the button below to send an immediate emergency alert to all security staff and management.</p>
                <button type="button" class="btn btn-light btn-lg w-100 fw-bold py-3 text-danger shadow"
                        data-bs-toggle="modal" data-bs-target="#sosModal">
                    <i class="bi bi-broadcast me-2"></i>SEND SOS NOW
                </button>
            </div>
        </div>

        {{-- Emergency Contacts --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3 border-bottom">
                <h6 class="mb-0 fw-bold text-danger">Quick Emergency Contacts</h6>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    @foreach($emergencyContacts as $contact)
                    <div class="list-group-item p-3 d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-{{ $contact['color'] }} bg-opacity-10 rounded-3 p-2 text-{{ $contact['color'] }}">
                                <i class="bi {{ $contact['icon'] }} fs-5"></i>
                            </div>
                            <div>
                                <div class="fw-bold small">{{ $contact['name'] }}</div>
                                <div class="text-muted" style="font-size:.75rem">{{ $contact['phone'] }}</div>
                            </div>
                        </div>
                        <a href="tel:{{ $contact['phone'] }}" class="btn btn-sm btn-{{ $contact['color'] }} rounded-circle">
                            <i class="bi bi-telephone-fill"></i>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Active & Past Alerts --}}
    <div class="col-lg-8">
        {{-- Success Message after SOS --}}
        @if(session('sos_sent'))
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center mb-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 me-3"></i>
            <div>
                <div class="fw-bold">{{ session('sos_sent') }}</div>
                <div class="small">Help is on the way. Stay where you are and keep your phone available.</div>
            </div>
        </div>
        @endif

        {{-- Active Alerts --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 fw-bold text-danger"><i class="bi bi-lightning-fill me-2"></i>Active Society Alerts</h6>
                <span class="badge bg-danger">{{ $activeAlerts->count() }} Active</span>
            </div>
            <div class="card-body p-0">
                @forelse($activeAlerts as $alert)
                <div class="p-4 border-bottom {{ $loop->first ? 'bg-danger bg-opacity-10' : '' }}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <div>
                            <span class="badge bg-{{ $alert->type === 'fire' ? 'danger' : ($alert->type === 'medical' ? 'success' : 'warning') }} mb-2">
                                {{ strtoupper($alert->type) }}
                            </span>
                            <h5 class="fw-bold mb-1">{{ $alert->title }}</h5>
                        </div>
                        <span class="text-muted small">{{ $alert->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="mb-2 text-muted">{{ $alert->description }}</p>
                    <div class="d-flex align-items-center gap-2 text-muted small">
                        <i class="bi bi-geo-alt-fill text-danger"></i>
                        <span>Location: <strong>{{ $alert->location }}</strong></span>
                    </div>
                </div>
                @empty
                <div class="p-5 text-center text-muted">
                    <i class="bi bi-check-circle text-success display-4 d-block mb-3"></i>
                    <h6>No active emergency alerts at this time.</h6>
                    <p class="small mb-0">The society is safe and secure.</p>
                </div>
                @endforelse
            </div>
        </div>

        {{-- Past Alerts --}}
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold text-muted">Recent Resolved Alerts</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Date</th>
                                <th>Alert Type</th>
                                <th>Description</th>
                                <th class="text-end pe-4">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pastAlerts as $alert)
                            <tr>
                                <td class="ps-4 text-muted small">{{ $alert->created_at->format('d M, Y') }}</td>
                                <td>
                                    <span class="badge bg-light text-dark border">{{ ucfirst($alert->type) }}</span>
                                </td>
                                <td><div class="text-truncate" style="max-width:250px">{{ $alert->description }}</div></td>
                                <td class="text-end pe-4">
                                    <span class="badge bg-secondary">Resolved</span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center text-muted py-4">No past alerts found</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SOS Modal --}}
<div class="modal fade" id="sosModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title fw-bold"><i class="bi bi-broadcast me-2"></i>Emergency SOS Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('resident.emergency.sos') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <p class="text-muted small mb-4">Please specify the type of emergency and your current location to help security reach you faster.</p>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Emergency Type <span class="text-danger">*</span></label>
                        <div class="row g-2">
                            @foreach(['fire' => 'Fire', 'medical' => 'Medical', 'security' => 'Security', 'other' => 'Other'] as $val => $label)
                            <div class="col-6">
                                <input type="radio" class="btn-check" name="type" id="type_{{ $val }}" value="{{ $val }}" required>
                                <label class="btn btn-outline-danger w-100" for="type_{{ $val }}">{{ $label }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Current Location / House #</label>
                        <input type="text" name="location" class="form-control" placeholder="e.g. House 42, Block B or Main Park"
                               value="{{ auth()->user()->resident?->house?->house_number }}">
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-bold">Emergency Description <span class="text-danger">*</span></label>
                        <textarea name="description" class="form-control" rows="3" required
                                  placeholder="Briefly describe the emergency..."></textarea>
                    </div>
                </div>
                <div class="modal-footer bg-light p-3 border-0">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-4 fw-bold">SEND SOS ALERT</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
