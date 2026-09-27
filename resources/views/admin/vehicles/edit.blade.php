@extends('layouts.admin')
@section('title', 'Edit Vehicle')
@section('page-title', 'Vehicle Management')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card border-0 shadow-sm">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-bold"><i class="bi bi-pencil me-2 text-primary"></i>Edit Vehicle Details</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Sticker Number <span class="text-danger">*</span></label>
                            <input type="text" name="sticker_number" class="form-control @error('sticker_number') is-invalid @enderror" value="{{ old('sticker_number', $vehicle->sticker_number) }}" required>
                            @error('sticker_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">House Number <span class="text-danger">*</span></label>
                            <select name="house_id" id="house_id" class="form-select @error('house_id') is-invalid @enderror" required>
                                @foreach($houses as $house)
                                    <option value="{{ $house->id }}" {{ old('house_id', $vehicle->house_id) == $house->id ? 'selected' : '' }}>
                                        {{ $house->house_number }} ({{ $house->block }})
                                    </option>
                                @endforeach
                            </select>
                            @error('house_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Owner Name</label>
                            <input type="text" id="owner_name" class="form-control bg-light" value="{{ $vehicle->resident->user->name ?? 'N/A' }}" readonly>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vehicle Number <span class="text-danger">*</span></label>
                            <input type="text" name="vehicle_number" class="form-control @error('vehicle_number') is-invalid @enderror" value="{{ old('vehicle_number', $vehicle->vehicle_number) }}" required>
                            @error('vehicle_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Vehicle Type <span class="text-danger">*</span></label>
                            <select name="vehicle_type" class="form-select @error('vehicle_type') is-invalid @enderror" required>
                                <option value="car" {{ old('vehicle_type', $vehicle->vehicle_type) == 'car' ? 'selected' : '' }}>Car</option>
                                <option value="bike" {{ old('vehicle_type', $vehicle->vehicle_type) == 'bike' ? 'selected' : '' }}>Bike</option>
                                <option value="suv" {{ old('vehicle_type', $vehicle->vehicle_type) == 'suv' ? 'selected' : '' }}>SUV</option>
                                <option value="van" {{ old('vehicle_type', $vehicle->vehicle_type) == 'van' ? 'selected' : '' }}>Van</option>
                                <option value="truck" {{ old('vehicle_type', $vehicle->vehicle_type) == 'truck' ? 'selected' : '' }}>Truck</option>
                                <option value="other" {{ old('vehicle_type', $vehicle->vehicle_type) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('vehicle_type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Registration Number <span class="text-danger">*</span></label>
                            <input type="text" name="registration_number" class="form-control @error('registration_number') is-invalid @enderror" value="{{ old('registration_number', $vehicle->registration_number) }}" required>
                            @error('registration_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
                            <select name="status" class="form-select @error('status') is-invalid @enderror" required>
                                <option value="active" {{ old('status', $vehicle->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $vehicle->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mt-4 d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-lg me-2"></i>Update Vehicle
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.getElementById('house_id').addEventListener('change', function() {
        const houseId = this.value;
        const ownerInput = document.getElementById('owner_name');
        
        if (houseId) {
            ownerInput.value = 'Loading...';
            fetch(`/admin/vehicles/owner/${houseId}`)
                .then(response => response.json())
                .then(data => {
                    ownerInput.value = data.owner_name;
                })
                .catch(error => {
                    ownerInput.value = 'Error fetching owner';
                });
        }
    });
</script>
@endpush
@endsection
