@extends('layouts.resident')
@section('title','My House')
@section('page-title','My House')
@section('content')
<div class="text-center py-5">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
         style="width:100px;height:100px">
        <i class="bi bi-house-x text-warning" style="font-size:3rem"></i>
    </div>
    <h4 class="fw-bold">No House Assigned</h4>
    <p class="text-muted">You have not been assigned to a house yet.<br>Please contact the society administrator.</p>
    <a href="{{ route('resident.dashboard') }}" class="btn btn-primary">
        <i class="bi bi-arrow-left me-2"></i>Back to Dashboard
    </a>
</div>
@endsection
