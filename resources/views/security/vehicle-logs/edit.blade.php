@extends('layouts.security')
@section('title', 'Edit Vehicle Log')
@section('page-title', 'Edit Vehicle Log')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil me-2 text-primary"></i>Edit Entry Record</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('security.vehicles.logs.update', $log) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="mb-3">
                        <label class="form-label fw-semibold">Vehicle Number</label>
                        <input type="text" name="vehicle_number" class="form-control" value="{{ $log->vehicle_number }}" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Driver Name (Optional)</label>
                        <input type="text" name="driver_name" class="form-control" value="{{ $log->driver_name }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Visiting House (Optional)</label>
                        <select name="house_id" class="form-select">
                            <option value="">Unknown / General</option>
                            @foreach($houses as $house)
                                <option value="{{ $house->id }}" {{ $log->house_id == $house->id ? 'selected' : '' }}>
                                    {{ $house->house_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="alert alert-info small py-2">
                        <i class="bi bi-info-circle me-2"></i>
                        You can only edit this record within 60 minutes of creation.
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-grow-1">Update Record</button>
                        <a href="{{ route('security.vehicles.logs.index') }}" class="btn btn-outline-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
