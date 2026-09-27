@extends('layouts.admin')

@section('title', 'Recycle Bin')

@section('content')
<div class="container-fluid">
    <div class="mb-4">
        <h2 class="h4">Deleted Records History (Recycle Bin)</h2>
        <p class="text-muted">Recently deleted records from all modules (Last 30 days). You can restore them or permanently delete them.</p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th>Record Type</th>
                        <th>Record Name/ID</th>
                        <th>Deleted By</th>
                        <th>Deleted Date & Time</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deletedRecords as $record)
                    <tr>
                        <td>
                            <span class="badge bg-secondary-subtle text-secondary">{{ $record->type }}</span>
                        </td>
                        <td><span class="fw-bold">{{ $record->name }}</span></td>
                        <td>{{ $record->deleted_by }}</td>
                        <td>{{ $record->deleted_at->format('d M, Y h:i A') }}</td>
                        <td class="text-end">
                            <form action="{{ route('admin.recycle-bin.restore') }}" method="POST" class="d-inline">
                                @csrf
                                <input type="hidden" name="model_class" value="{{ $record->model_class }}">
                                <input type="hidden" name="id" value="{{ $record->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-arrow-counterclockwise me-1"></i>Restore
                                </button>
                            </form>
                            
                            @if(Auth::user()->role == 'admin')
                            <form action="{{ route('admin.recycle-bin.permanent-delete') }}" method="POST" class="d-inline" onsubmit="return confirm('WARNING: This will permanently delete the record. This action cannot be undone. Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <input type="hidden" name="model_class" value="{{ $record->model_class }}">
                                <input type="hidden" name="id" value="{{ $record->id }}">
                                <button type="submit" class="btn btn-sm btn-outline-danger ms-2">
                                    <i class="bi bi-x-circle me-1"></i>Permanent Delete
                                </button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-5 text-muted">
                            <i class="bi bi-trash fs-1 d-block mb-3"></i>
                            No recently deleted records found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
