@extends('layouts.security')
@section('title', 'Incident Details')
@section('page-title', 'Incident Details')

@section('content')
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 mb-4 overflow-hidden">
            @if($incident->image)
                <div class="bg-dark text-center py-2">
                    <img src="{{ asset('storage/' . $incident->image) }}" class="img-fluid rounded" style="max-height: 400px;">
                </div>
            @endif
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 mb-2">{{ $incident->type_label }}</span>
                        <h4 class="fw-bold mb-1">{{ $incident->title }}</h4>
                        <div class="text-muted small"><i class="bi bi-geo-alt me-1"></i> {{ $incident->location }}</div>
                    </div>
                    {!! $incident->status_badge !!}
                </div>
                <hr class="opacity-10 my-4">
                <h6 class="fw-bold mb-3 text-dark">INCIDENT DESCRIPTION</h6>
                <p class="text-secondary" style="line-height: 1.8;">{{ $incident->description }}</p>

                @if($incident->status === 'resolved')
                    <div class="mt-5 p-4 bg-success bg-opacity-10 rounded-3 border border-success border-opacity-25">
                        <h6 class="fw-bold text-success mb-2"><i class="bi bi-check-circle-fill me-2"></i>RESOLUTION DETAILS</h6>
                        <p class="mb-2 text-dark">{{ $incident->resolution_notes }}</p>
                        <small class="text-muted">Resolved on: {{ $incident->resolved_at->format('d M Y, H:i') }}</small>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Report Summary</h6>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span class="text-muted small">Reported By</span>
                        <span class="fw-bold small">{{ $incident->reporter->name }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span class="text-muted small">Date Reported</span>
                        <span class="fw-bold small">{{ $incident->created_at->format('d M Y') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span class="text-muted small">Time Reported</span>
                        <span class="fw-bold small">{{ $incident->created_at->format('H:i A') }}</span>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0 py-2 border-0">
                        <span class="text-muted small">Status</span>
                        <span>{!! $incident->status_badge !!}</span>
                    </li>
                </ul>
            </div>
        </div>

        @if($incident->status !== 'resolved')
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold">Update Status</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.incidents.status', $incident) }}" method="POST">
                    @csrf @method('PATCH')
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Select Status</label>
                        <select name="status" class="form-select @error('status') is-invalid @enderror" id="statusSelect" required>
                            <option value="under_review" {{ $incident->status === 'under_review' ? 'selected' : '' }}>Under Review</option>
                            <option value="resolved">Mark as Resolved</option>
                        </select>
                        @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div id="resolutionField" class="{{ $incident->status === 'resolved' ? '' : 'd-none' }}">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Resolution Notes <span class="text-danger">*</span></label>
                            <textarea name="resolution_notes" class="form-control @error('resolution_notes') is-invalid @enderror" rows="4" placeholder="How was this incident resolved?">{{ old('resolution_notes') }}</textarea>
                            @error('resolution_notes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <button type="submit" class="btn btn-dark w-100 fw-bold">Update Incident Status</button>
                </form>
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('statusSelect').addEventListener('change', function() {
        const resolutionField = document.getElementById('resolutionField');
        if (this.value === 'resolved') {
            resolutionField.classList.remove('d-none');
        } else {
            resolutionField.classList.add('d-none');
        }
    });
</script>
@endpush
@endsection
