@extends('layouts.admin')
@section('title', 'Notice Details')
@section('page-title', 'Notice Details')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">{{ $notice->title }}</h5>
        <p class="text-muted small mb-0">Created on {{ $notice->created_at->format('d M Y, H:i') }} by {{ $notice->createdBy->name ?? 'Unknown' }}</p>
    </div>
    <a href="{{ route('admin.notices.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Notices
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <span class="fw-semibold">Notice Content</span>
                <div class="d-flex gap-2">
                    {!! $notice->type_badge !!}
                    {!! $notice->priority_badge !!}
                </div>
            </div>
            <div class="card-body">
                <p class="mb-0">{!! nl2br(e($notice->content)) !!}</p>
            </div>
        </div>
        
        @if($notice->attachment)
        <div class="card mb-4">
            <div class="card-header bg-white fw-semibold">Attachment</div>
            <div class="card-body">
                <a href="{{ asset('storage/' . $notice->attachment) }}" target="_blank" class="btn btn-outline-primary">
                    <i class="bi bi-download me-2"></i>Download Attachment
                </a>
            </div>
        </div>
        @endif

        <div class="card">
            <div class="card-header bg-white fw-semibold">Recipients</div>
            <div class="card-body">
                <h6 class="fw-semibold">Target Type: {{ ucfirst($notice->target_type) }}</h6>
                @if($notice->target_blocks)
                    <p class="mb-1"><strong>Blocks:</strong> {{ implode(', ', $notice->target_blocks) }}</p>
                @endif
                @if($notice->target_houses)
                    <p class="mb-1"><strong>Houses:</strong> {{ implode(', ', $notice->target_houses) }}</p>
                @endif
                <p class="mb-0"><strong>Delivery Count:</strong> {{ $notice->delivery_count }}</p>
                <p class="mb-0"><strong>Read Count:</strong> {{ $notice->read_count }}</p>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card mb-4">
            <div class="card-header bg-white fw-semibold">Publishing</div>
            <div class="card-body">
                <p class="mb-1"><strong>Status:</strong> {{ $notice->is_published ? 'Published' : 'Draft' }}</p>
                @if($notice->publish_at)
                    <p class="mb-1"><strong>Publish At:</strong> {{ $notice->publish_at->format('d M Y, H:i') }}</p>
                @endif
                @if($notice->expires_at)
                    <p class="mb-0"><strong>Expires At:</strong> {{ $notice->expires_at->format('d M Y, H:i') }}</p>
                @endif
            </div>
            <div class="card-footer bg-white">
                <a href="{{ route('admin.notices.edit', $notice) }}" class="btn btn-primary w-100">
                    <i class="bi bi-pencil me-2"></i>Edit Notice
                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-header bg-white fw-semibold">Read Status</div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>User</th>
                                <th>Read At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($notice->readByUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>
                                    @if($user->pivot->read_at)
                                        {{ $user->pivot->read_at->format('d M Y, H:i') }}
                                    @else
                                        <span class="text-muted">Not read</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="2" class="text-center py-4 text-muted">
                                    No users have read this notice yet
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
