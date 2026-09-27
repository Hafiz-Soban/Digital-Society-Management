@extends('layouts.admin')
@section('title', 'Notices')
@section('page-title', 'Notice Management')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Notices</h5>
        <p class="text-muted small mb-0">Manage society announcements and notices</p>
    </div>
    <a href="{{ route('admin.notices.create') }}" class="btn btn-primary">
        <i class="bi bi-megaphone me-2"></i>Create Notice
    </a>
</div>

<!-- Search & Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" class="row g-3">
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-search"></i></span>
                    <input type="text" name="search" class="form-control" placeholder="Search by title..." value="{{ request('search') }}">
                </div>
            </div>
            <div class="col-md-2">
                <select name="type" class="form-select">
                    <option value="">All Types</option>
                    <option value="general" {{ request('type') == 'general' ? 'selected' : '' }}>General</option>
                    <option value="maintenance" {{ request('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                    <option value="event" {{ request('type') == 'event' ? 'selected' : '' }}>Event</option>
                    <option value="emergency" {{ request('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                    <option value="rule" {{ request('type') == 'rule' ? 'selected' : '' }}>Rule/Policy</option>
                </select>
            </div>
            <div class="col-md-2">
                <select name="priority" class="form-select">
                    <option value="">All Priority</option>
                    <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>Low</option>
                    <option value="normal" {{ request('priority') == 'normal' ? 'selected' : '' }}>Normal</option>
                    <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>High</option>
                    <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                </select>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">Filter</button>
            </div>
            <div class="col-md-2">
                <a href="{{ route('admin.notices.index') }}" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Type</th>
                        <th>Priority</th>
                        <th>Target</th>
<<<<<<< HEAD
                        <th>Delivery / Read</th>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <th>Published</th>
                        <th>Publish Date</th>
                        <th>Expires</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notices as $notice)
                    <tr>
                        <td>
                            <div class="fw-semibold">{{ Str::limit($notice->title, 50) }}</div>
                            <div class="text-muted small">{{ Str::limit(strip_tags($notice->content), 60) }}</div>
                        </td>
<<<<<<< HEAD
                        <td>{!! $notice->type_badge !!}</td>
                        <td>{!! $notice->priority_badge !!}</td>
                        <td>
                            <span class="badge bg-light text-dark border">
                                {{ ucfirst($notice->target_type ?? 'All') }}
                            </span>
                        </td>
                        <td>
                            <div class="small">
                                <span class="text-success">{{ $notice->read_count }}</span> / {{ $notice->delivery_count }}
                            </div>
                        </td>
                        <td>
                            @if($notice->is_published)
                                <span class="text-success"><i class="bi bi-check-circle"></i></span>
                            @else
                                <span class="text-secondary"><i class="bi bi-x-circle"></i></span>
                            @endif
=======
                        <td>
                            @php
                                $typeColors = ['general' => 'secondary', 'maintenance' => 'warning', 'event' => 'info', 'emergency' => 'danger', 'rule' => 'dark'];
                                $typeColor = $typeColors[$notice->type] ?? 'secondary';
                            @endphp
                            <span class="badge bg-{{ $typeColor }}">{{ ucfirst($notice->type) }}</span>
                        </td>
                        <td>{!! $notice->priority_badge !!}</td>
                        <td>
                            <span class="badge bg-light text-dark border">{{ ucfirst($notice->target_audience ?? 'All') }}</span>
                        </td>
                        <td>
                            <form method="POST" action="{{ route('admin.notices.toggle', $notice) }}" class="d-inline">
                                @csrf @method('PATCH')
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input" type="checkbox" onchange="this.form.submit()"
                                        {{ $notice->is_published ? 'checked' : '' }}>
                                </div>
                            </form>
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        </td>
                        <td>{{ $notice->publish_at?->format('d M Y') ?? '-' }}</td>
                        <td>
                            @if($notice->expires_at)
                                @if($notice->expires_at->isPast())
                                    <span class="text-danger small">{{ $notice->expires_at->format('d M Y') }} (Expired)</span>
                                @else
                                    <span class="text-muted small">{{ $notice->expires_at->format('d M Y') }}</span>
                                @endif
                            @else
                                <span class="text-muted small">No expiry</span>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex gap-1">
<<<<<<< HEAD
                                <a href="{{ route('admin.notices.show', $notice) }}" class="btn btn-sm btn-outline-info" title="View Details">
                                    <i class="bi bi-eye"></i>
                                </a>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                                <a href="{{ route('admin.notices.edit', $notice) }}" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button type="button" class="btn btn-sm btn-outline-danger" title="Delete"
                                    data-bs-toggle="modal" data-bs-target="#deleteNoticeModal{{ $notice->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>

                            <!-- Delete Modal -->
                            <div class="modal fade" id="deleteNoticeModal{{ $notice->id }}" tabindex="-1">
                                <div class="modal-dialog modal-sm">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title">Confirm Delete</h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <p class="mb-0">Delete notice <strong>{{ Str::limit($notice->title, 30) }}</strong>?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form method="POST" action="{{ route('admin.notices.destroy', $notice) }}">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
<<<<<<< HEAD
                        <td colspan="9" class="text-center py-5 text-muted">
=======
                        <td colspan="8" class="text-center py-5 text-muted">
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                            <i class="bi bi-megaphone fs-1 d-block mb-2"></i>
                            No notices found
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
<<<<<<< HEAD
    @if($notices->hasMorePages())
=======
    @if($notices->hasPages())
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    <div class="card-footer bg-white">
        {{ $notices->links() }}
    </div>
    @endif
</div>
@endsection
