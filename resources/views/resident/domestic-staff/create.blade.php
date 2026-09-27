@extends('layouts.resident')
@section('title','Add Staff')
@section('page-title','Add Domestic Staff')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Add Domestic Staff</h5>
        <p class="text-muted small mb-0">Create a staff profile and generate a QR code</p>
    </div>
    <a href="{{ route('resident.domestic-staff.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-person-plus me-2 text-primary"></i>Staff Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.domestic-staff.store') }}" enctype="multipart/form-data">
                    @csrf
                    @include('resident.domestic-staff._form', ['staffMember' => null])
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('resident.domestic-staff.index') }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-person-plus me-2"></i>Add Staff
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

