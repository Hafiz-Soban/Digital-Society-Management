@extends('layouts.security')
@section('title', 'Notice Details')
@section('page-title', 'Notice Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-9">
        <div class="mb-4">
            <a href="{{ route('security.notices.index') }}" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i> Back to Notices
            </a>
        </div>

        <div class="card shadow-sm border-0 mb-4 overflow-hidden">
            <div class="card-header bg-white py-4 px-4 border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-{{ $notice->priority === 'high' || $notice->priority === 'urgent' ? 'danger' : 'info' }} px-3">
                        {{ strtoupper($notice->priority) }} PRIORITY
                    </span>
                    <small class="text-muted"><i class="bi bi-calendar3 me-1"></i> Posted on {{ $notice->created_at->format('d M, Y \a\t H:i') }}</small>
                </div>
                <h2 class="fw-bold mb-0 text-dark">{{ $notice->title }}</h2>
            </div>
            <div class="card-body px-4 py-0">
                <hr class="mt-0 mb-4 opacity-10">
                <div class="notice-content text-dark mb-5" style="line-height: 1.8; font-size: 1.1rem;">
                    {!! nl2br(e($notice->content)) !!}
                </div>

                @if($notice->attachment)
                <div class="bg-light rounded-3 p-4 mb-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-3 p-3 shadow-sm text-danger">
                            <i class="bi bi-file-earmark-pdf-fill fs-3"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Notice Attachment</div>
                            <div class="text-muted small">Download for full details</div>
                        </div>
                    </div>
                    <a href="{{ asset('storage/' . $notice->attachment) }}" target="_blank" class="btn btn-primary px-4">
                        <i class="bi bi-download me-2"></i>Download
                    </a>
                </div>
                @endif
            </div>
            <div class="card-footer bg-light py-4 px-4 border-0">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2 text-primary">
                                <i class="bi bi-person-badge fs-5"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Posted By</div>
                                <div class="fw-bold small">Society Management</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 text-md-end mt-3 mt-md-0">
                        <span class="badge bg-white text-primary border border-primary border-opacity-25 px-3 py-2">
                            <i class="bi bi-tag-fill me-1"></i> {{ ucfirst($notice->type) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
