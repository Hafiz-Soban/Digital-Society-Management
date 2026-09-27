@extends('layouts.security')
@section('title', 'Verify Resident')
@section('page-title', 'Resident Verification')

@section('content')
<div class="card mb-4 shadow-sm border-0">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3"><i class="bi bi-search me-2 text-danger"></i>SEARCH RESIDENT OR HOUSE</h6>
        <form action="{{ route('security.residents.index') }}" method="GET">
            <div class="input-group input-group-lg">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search text-muted"></i></span>
                <input type="text" name="search" class="form-control border-start-0" 
                       placeholder="Enter Name, House #, Block, Resident ID or Phone..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-danger px-5 fw-bold">SEARCH</button>
            </div>
            <div class="form-text mt-2 small text-muted">Verification is mandatory before allowing visitors or resolving issues related to specific houses.</div>
        </form>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Resident Name</th>
                        <th>Resident ID</th>
                        <th>House Info</th>
                        <th>Contact Number</th>
                        <th>Status</th>
                        <th class="text-end pe-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($residents as $resident)
                    <tr>
                        <td class="ps-4">
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $resident->user->avatar_url }}" class="rounded-circle border" width="40" height="40" style="object-fit: cover;">
                                <div class="fw-bold text-dark">{{ $resident->user->name }}</div>
                            </div>
                        </td>
                        <td><span class="badge bg-light text-dark border">{{ $resident->resident_id }}</span></td>
                        <td>
                            <div class="fw-bold">House: {{ $resident->house->house_number ?? 'N/A' }}</div>
                            <small class="text-muted">Block: {{ $resident->house->block ?? 'N/A' }}, Floor: {{ $resident->house->floor ?? 'N/A' }}</small>
                        </td>
                        <td>{{ $resident->user->phone ?? 'N/A' }}</td>
                        <td>{!! $resident->status_badge !!}</td>
                        <td class="text-end pe-4">
                            <a href="{{ route('security.residents.show', $resident) }}" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                <i class="bi bi-shield-check me-1"></i> Verify
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted">No residents found matching your search.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white border-0 py-3">
        {{ $residents->links() }}
    </div>
</div>
@endsection
