@extends('layouts.admin')
@section('title', 'Create Notice')
@section('page-title', 'Create Notice')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h5 class="fw-bold mb-1">Create New Notice</h5>
        <p class="text-muted small mb-0">Publish an announcement to society residents</p>
    </div>
    <a href="{{ route('admin.notices.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left me-2"></i>Back to Notices
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-white py-3">
                <h6 class="mb-0 fw-semibold"><i class="bi bi-megaphone me-2 text-primary"></i>Notice Details</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.notices.store') }}">
                    @csrf

                    <div class="row g-3">
                        <!-- Title -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Title <span class="text-danger">*</span></label>
<<<<<<< HEAD
                            <input type="text" name="title" id="noticeTitle" class="form-control @error('title') is-invalid @enderror"
=======
                            <input type="text" name="title" class="form-control @error('title') is-invalid @enderror"
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                                value="{{ old('title') }}" placeholder="Notice title..." required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

<<<<<<< HEAD
                        <!-- Smart Suggestion -->
                        <div class="col-12" id="smartSuggestion" style="display: none;">
                            <div class="alert alert-info d-flex align-items-center gap-2">
                                <i class="bi bi-lightbulb"></i>
                                <span id="suggestionText"></span>
                            </div>
                        </div>

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <!-- Content -->
                        <div class="col-12">
                            <label class="form-label fw-semibold">Content <span class="text-danger">*</span></label>
                            <textarea name="content" class="form-control @error('content') is-invalid @enderror"
                                rows="6" placeholder="Write the notice content here..." required>{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Type -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-select @error('type') is-invalid @enderror" required>
                                <option value="">Select Type</option>
                                <option value="general" {{ old('type') == 'general' ? 'selected' : '' }}>General</option>
                                <option value="maintenance" {{ old('type') == 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                                <option value="event" {{ old('type') == 'event' ? 'selected' : '' }}>Event</option>
                                <option value="emergency" {{ old('type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                                <option value="rule" {{ old('type') == 'rule' ? 'selected' : '' }}>Rule / Policy</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Priority -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Priority <span class="text-danger">*</span></label>
                            <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                <option value="">Select Priority</option>
                                <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                                <option value="normal" {{ old('priority', 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                                <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                            @error('priority')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

<<<<<<< HEAD
                        <!-- Target Type -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Target Audience <span class="text-danger">*</span></label>
                            <select name="target_type" id="targetType" class="form-select @error('target_type') is-invalid @enderror" required>
                                <option value="all" {{ old('target_type', 'all') == 'all' ? 'selected' : '' }}>Entire Society</option>
                                <option value="block" {{ old('target_type') == 'block' ? 'selected' : '' }}>Specific Block</option>
                                <option value="house" {{ old('target_type') == 'house' ? 'selected' : '' }}>Specific House</option>
                                <option value="residents" {{ old('target_type') == 'residents' ? 'selected' : '' }}>Residents Only</option>
                                <option value="security" {{ old('target_type') == 'security' ? 'selected' : '' }}>Security Staff Only</option>
                                <option value="staff" {{ old('target_type') == 'staff' ? 'selected' : '' }}>Society Staff Only</option>
                                <option value="custom" {{ old('target_type') == 'custom' ? 'selected' : '' }}>Custom Selection</option>
                            </select>
                            @error('target_type')
=======
                        <!-- Target Audience -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Target Audience</label>
                            <select name="target_audience" class="form-select @error('target_audience') is-invalid @enderror">
                                <option value="all" {{ old('target_audience', 'all') == 'all' ? 'selected' : '' }}>All Residents</option>
                                <option value="owners" {{ old('target_audience') == 'owners' ? 'selected' : '' }}>Owners Only</option>
                                <option value="tenants" {{ old('target_audience') == 'tenants' ? 'selected' : '' }}>Tenants Only</option>
                            </select>
                            @error('target_audience')
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

<<<<<<< HEAD
                        <!-- Block Selection -->
                        <div class="col-md-6" id="blockSelection" style="display: none;">
                            <label class="form-label fw-semibold">Select Blocks</label>
                            <select name="target_blocks[]" class="form-select" multiple id="blockSelect">
                                @foreach($blocks as $block)
                                    <option value="{{ $block }}" {{ is_array(old('target_blocks')) && in_array($block, old('target_blocks')) ? 'selected' : '' }}>
                                        Block {{ $block }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple blocks</div>
                        </div>

                        <!-- House Selection -->
                        <div class="col-md-6" id="houseSelection" style="display: none;">
                            <label class="form-label fw-semibold">Select Houses</label>
                            <select name="target_houses[]" class="form-select" multiple id="houseSelect">
                                @foreach($houses as $house)
                                    <option value="{{ $house->id }}" {{ is_array(old('target_houses')) && in_array($house->id, old('target_houses')) ? 'selected' : '' }}>
                                        {{ $house->house_number }} @if($house->block) (Block {{ $house->block }}) @endif
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple houses</div>
                        </div>

                        <!-- Custom Selection (Users) -->
                        <div class="col-12" id="userSelection" style="display: none;">
                            <label class="form-label fw-semibold">Select Users</label>
                            <select name="target_users[]" class="form-select" multiple id="userSelect">
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ is_array(old('target_users')) && in_array($user->id, old('target_users')) ? 'selected' : '' }}>
                                        {{ $user->name }} ({{ $user->role->name ?? 'N/A' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Hold Ctrl/Cmd to select multiple users</div>
                        </div>

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
                        <!-- Publish At -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Publish Date & Time</label>
                            <input type="datetime-local" name="publish_at" class="form-control @error('publish_at') is-invalid @enderror"
                                value="{{ old('publish_at') }}">
                            <div class="form-text">Leave blank to publish immediately when toggled on.</div>
                            @error('publish_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Expires At -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Expiry Date & Time</label>
                            <input type="datetime-local" name="expires_at" class="form-control @error('expires_at') is-invalid @enderror"
                                value="{{ old('expires_at') }}">
                            <div class="form-text">Leave blank for no expiry.</div>
                            @error('expires_at')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Is Published -->
                        <div class="col-12">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="is_published" value="1"
                                    id="isPublished" {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label fw-semibold" for="isPublished">
                                    Publish immediately
                                </label>
                                <div class="form-text">If checked, the notice will be visible to residents right away.</div>
                            </div>
                        </div>
                    </div>

                    <hr class="my-4">
                    <div class="d-flex gap-2 justify-content-end">
                        <a href="{{ route('admin.notices.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-megaphone me-2"></i>Create Notice
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<<<<<<< HEAD

<script>
// Smart Suggestions based on title
document.getElementById('noticeTitle').addEventListener('input', function() {
    const title = this.value.toLowerCase();
    const suggestionDiv = document.getElementById('smartSuggestion');
    const suggestionText = document.getElementById('suggestionText');
    const targetTypeSelect = document.getElementById('targetType');
    
    let suggestion = null;
    
    if (title.includes('water') || title.includes('supply')) {
        suggestion = 'Would you like to send this notice only to affected blocks?';
    } else if (title.includes('lift') || title.includes('elevator') || title.includes('maintenance')) {
        suggestion = 'Select affected building/floor/block.';
    } else if (title.includes('security') || title.includes('alert') || title.includes('emergency')) {
        suggestion = 'Send to entire society.';
    }
    
    if (suggestion) {
        suggestionText.textContent = suggestion;
        suggestionDiv.style.display = 'block';
    } else {
        suggestionDiv.style.display = 'none';
    }
});

// Show/Hide target options based on target type
document.getElementById('targetType').addEventListener('change', function() {
    const type = this.value;
    document.getElementById('blockSelection').style.display = (type === 'block' || type === 'custom') ? 'block' : 'none';
    document.getElementById('houseSelection').style.display = (type === 'house' || type === 'custom') ? 'block' : 'none';
    document.getElementById('userSelection').style.display = (type === 'custom') ? 'block' : 'none';
});

// Initial check on page load
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('targetType').dispatchEvent(new Event('change'));
});
</script>
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
@endsection
