@extends('layouts.resident')
@section('title', $notice->title)
@section('page-title', 'Notice Details')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="mb-4 d-flex justify-content-between align-items-center">
            <a href="{{ route('resident.notices.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-arrow-left me-2"></i>Back to Notice Board
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print()" class="btn btn-outline-primary btn-sm">
                    <i class="bi bi-printer me-1"></i> Print
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm overflow-hidden mb-4">
            <div class="card-header bg-white py-4 px-4 border-0">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="badge bg-{{ $notice->priority === 'high' ? 'danger' : ($notice->priority === 'medium' ? 'warning' : 'info') }} px-3">
                        {{ strtoupper($notice->priority) }} PRIORITY
                    </span>
                    <span class="text-muted small"><i class="bi bi-calendar3 me-1"></i> Posted on {{ $notice->created_at->format('d M, Y \a\t H:i') }}</span>
                </div>
                <h2 class="fw-bold mb-0 text-dark">{{ $notice->title }}</h2>
            </div>
            <div class="card-body px-4 py-0">
                <hr class="mt-0 mb-4 opacity-10">
                <div class="notice-content text-dark mb-5" style="line-height: 1.8; font-size: 1.05rem;">
                    {!! nl2br(e($notice->content)) !!}
                </div>

                @if($notice->attachment)
                <div class="bg-light rounded-3 p-4 mb-4 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-white rounded-3 p-3 shadow-sm">
                            <i class="bi bi-file-earmark-pdf-fill fs-3 text-danger"></i>
                        </div>
                        <div>
                            <div class="fw-bold">Official Attachment</div>
                            <div class="text-muted small">Download for more details</div>
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
                            <div class="bg-primary bg-opacity-10 rounded-circle p-2" style="width:45px;height:45px;display:flex;align-items:center;justify-content:center">
                                <i class="bi bi-person-badge text-primary fs-5"></i>
                            </div>
                            <div>
                                <div class="text-muted small">Posted By</div>
                                <div class="fw-bold small">{{ $notice->author->name ?? 'Society Management' }}</div>
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

        {{-- Disclaimer --}}
        <div class="alert alert-info border-0 shadow-sm d-flex gap-3 mb-5">
            <i class="bi bi-info-circle-fill fs-4"></i>
            <div>
                <div class="fw-bold small">Official Communication</div>
                <div class="small">This is an official notice from the Society Management. For any queries regarding this notice, please contact the Management Office via the directory.</div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .btn, .alert, .card-footer { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
    .page-title { display: block !important; margin-bottom: 2rem; text-align: center; }
}
</style>
@endsection
