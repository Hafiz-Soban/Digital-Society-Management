@extends('layouts.resident')
@section('title','Edit Staff')
@section('page-title','Edit Domestic Staff')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Edit Staff</h5>
        <p class="text-muted small mb-0">Update staff profile information</p>
    </div>
    <a href="{{ route('resident.domestic-staff.show', $staffMember->id) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-9">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-pencil-square me-2 text-primary"></i>Staff Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('resident.domestic-staff.update', $staffMember->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    @include('resident.domestic-staff._form')
                    <div class="d-flex gap-2 justify-content-end mt-4">
                        <a href="{{ route('resident.domestic-staff.show', $staffMember->id) }}" class="btn btn-outline-secondary px-4">Cancel</a>
                        <button type="submit" class="btn btn-primary px-4">
                            <i class="bi bi-check2-circle me-2"></i>Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

