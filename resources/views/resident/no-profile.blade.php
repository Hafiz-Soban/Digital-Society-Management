@extends('layouts.resident')
@section('title','No Profile')
@section('page-title','Profile Not Found')
@section('content')
<div class="text-center py-5">
    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4"
         style="width:100px;height:100px">
        <i class="bi bi-person-x text-warning" style="font-size:3rem"></i>
    </div>
    <h4 class="fw-bold">Resident Profile Not Found</h4>
    <p class="text-muted">Your account is not linked to a resident profile yet.<br>Please contact the society administrator.</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary">
            <i class="bi bi-box-arrow-right me-2"></i>Logout
        </button>
    </form>
</div>
@endsection
