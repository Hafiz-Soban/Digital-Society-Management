@extends('layouts.admin')

@section('title', 'Edit Emergency Contact')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.emergency-contacts.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Contacts
        </a>
        <h2 class="h4">Edit Emergency Contact</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.emergency-contacts.update', $emergencyContact) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $emergencyContact->name) }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number', $emergencyContact->phone_number) }}" required>
                            @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation / Department</label>
                            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" value="{{ old('designation', $emergencyContact->designation) }}" required>
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Priority Level</label>
                            <select name="priority_level" class="form-select">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ old('priority_level', $emergencyContact->priority_level) == $i ? 'selected' : '' }}>Priority {{ $i }}</option>
                                @endfor
                            </select>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Update Emergency Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
