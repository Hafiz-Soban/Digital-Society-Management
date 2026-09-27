@extends('layouts.admin')

@section('title', 'Add Emergency Contact')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <a href="{{ route('admin.emergency-contacts.index') }}" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="bi bi-arrow-left me-1"></i>Back to Contacts
        </a>
        <h2 class="h4">Add Emergency Contact</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <form action="{{ route('admin.emergency-contacts.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" placeholder="e.g. Society Supervisor" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror" placeholder="e.g. 0300-1234567" required>
                            @error('phone_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation / Department</label>
                            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror" placeholder="e.g. Security Office, Maintenance" required>
                            @error('designation') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Priority Level</label>
                            <select name="priority_level" class="form-select">
                                <option value="1">Priority 1 (Highest)</option>
                                <option value="2">Priority 2</option>
                                <option value="3" selected>Priority 3</option>
                                <option value="4">Priority 4</option>
                                <option value="5">Priority 5 (Lowest)</option>
                            </select>
                            <small class="text-muted">Determines the order of appearance on the directory.</small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Save Emergency Contact</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
