@extends('layouts.admin')

@section('title', 'Emergency Contacts')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h4 mb-0">Emergency Contacts</h2>
        <a href="{{ route('admin.emergency-contacts.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Add Contact
        </a>
    </div>

    <div class="row g-4">
        @forelse($contacts as $contact)
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="bg-danger-subtle text-danger rounded p-2">
                            <i class="bi bi-telephone-fill fs-4"></i>
                        </div>
                        <span class="badge bg-dark">Priority {{ $contact->priority_level }}</span>
                    </div>
                    <h5 class="card-title mb-1">{{ $contact->name }}</h5>
                    <p class="text-muted small mb-3">{{ $contact->designation }}</p>
                    <div class="h4 text-primary mb-3">{{ $contact->phone_number }}</div>
                    
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.emergency-contacts.edit', $contact) }}" class="btn btn-sm btn-outline-dark">
                            <i class="bi bi-pencil me-1"></i>Edit
                        </a>
                        <form action="{{ route('admin.emergency-contacts.destroy', $contact) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                <i class="bi bi-trash me-1"></i>Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm p-5 text-center">
                <i class="bi bi-telephone-x fs-1 text-muted mb-3"></i>
                <p class="text-muted">No emergency contacts found.</p>
                <div>
                    <a href="{{ route('admin.emergency-contacts.create') }}" class="btn btn-primary">Add Your First Contact</a>
                </div>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
