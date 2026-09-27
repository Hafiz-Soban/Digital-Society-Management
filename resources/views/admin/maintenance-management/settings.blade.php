@extends('layouts.admin')
@section('title', 'Maintenance Settings')
@section('page-title', 'Maintenance Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-gear me-2 text-primary"></i>Maintenance Configuration</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.maintenance-management.settings.update') }}" method="POST">
                    @csrf
                    
                    <div class="mb-4">
                        <label class="form-label fw-semibold">Monthly Maintenance Amount (PKR)</label>
                        <div class="input-group">
                            <span class="input-group-text">PKR</span>
                            <input type="number" name="monthly_amount" class="form-control" value="{{ $settings['monthly_amount'] }}" required min="0">
                        </div>
                        <small class="text-muted">This amount will be charged to all residents monthly.</small>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">Auto Monthly Maintenance</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="auto_enabled" id="auto_enabled" value="enabled" {{ $settings['auto_enabled'] == 'enabled' ? 'checked' : '' }}>
                            <label class="form-check-label" for="auto_enabled">Automatically generate maintenance charges on the 1st of every month</label>
                        </div>
                        <input type="hidden" name="auto_enabled" value="disabled" id="auto_enabled_hidden" {{ $settings['auto_enabled'] == 'enabled' ? 'disabled' : '' }}>
                    </div>

                    <hr class="my-4">

                    <div class="mb-4">
                        <label class="form-label fw-semibold d-block">Complaint Restriction For Defaulters</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="restriction_enabled" id="restriction_enabled" value="enabled" {{ $settings['restriction_enabled'] == 'enabled' ? 'checked' : '' }}>
                            <label class="form-check-label" for="restriction_enabled">Block standard complaints for residents with dues exceeding PKR 10,000</label>
                        </div>
                        <input type="hidden" name="restriction_enabled" value="disabled" id="restriction_enabled_hidden" {{ $settings['restriction_enabled'] == 'enabled' ? 'disabled' : '' }}>
                        <div class="alert alert-info mt-2 small">
                            <i class="bi bi-info-circle me-1"></i> Emergency alerts (Fire, Medical, etc.) will never be blocked.
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary py-2">
                            <i class="bi bi-check-lg me-2"></i>Save Settings
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
        const autoCheck = document.getElementById('auto_enabled');
        const autoHidden = document.getElementById('auto_enabled_hidden');
        const restCheck = document.getElementById('restriction_enabled');
        const restHidden = document.getElementById('restriction_enabled_hidden');

        autoCheck.addEventListener('change', function() {
            autoHidden.disabled = this.checked;
        });

        restCheck.addEventListener('change', function() {
            restHidden.disabled = this.checked;
        });
    });
</script>
@endpush
@endsection
