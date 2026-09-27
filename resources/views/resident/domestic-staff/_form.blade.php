<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold">Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
               value="{{ old('name', $staffMember->name ?? '') }}" required>
        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold">Staff Type <span class="text-danger">*</span></label>
        <select name="staff_type" class="form-select @error('staff_type') is-invalid @enderror" required>
            <option value="" disabled {{ old('staff_type', $staffMember->staff_type ?? '') === '' ? 'selected' : '' }}>Select type</option>
            @foreach($staffTypes as $key => $label)
                <option value="{{ $key }}" {{ old('staff_type', $staffMember->staff_type ?? '') === $key ? 'selected' : '' }}>{{ $label }}</option>
            @endforeach
        </select>
        @error('staff_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">CNIC</label>
        <input type="text" name="cnic" class="form-control @error('cnic') is-invalid @enderror"
               value="{{ old('cnic', $staffMember->cnic ?? '') }}" placeholder="42101-1234567-1">
        @error('cnic')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Mobile</label>
        <input type="text" name="mobile" class="form-control @error('mobile') is-invalid @enderror"
               value="{{ old('mobile', $staffMember->mobile ?? '') }}" placeholder="+92 300 0000000">
        @error('mobile')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-4">
        <label class="form-label fw-semibold">Joining Date</label>
        <input type="date" name="joining_date" class="form-control @error('joining_date') is-invalid @enderror"
               value="{{ old('joining_date', isset($staffMember) && $staffMember->joining_date ? $staffMember->joining_date->format('Y-m-d') : '') }}">
        @error('joining_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-md-4">
        <label class="form-label fw-semibold">Status <span class="text-danger">*</span></label>
        <select name="status" class="form-select @error('status') is-invalid @enderror" required>
            <option value="active" {{ old('status', $staffMember->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $staffMember->status ?? 'active') === 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>
    <div class="col-md-8">
        <label class="form-label fw-semibold">Emergency Contact</label>
        <input type="text" name="emergency_contact" class="form-control @error('emergency_contact') is-invalid @enderror"
               value="{{ old('emergency_contact', $staffMember->emergency_contact ?? '') }}" placeholder="Name / Phone">
        @error('emergency_contact')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Address</label>
        <textarea name="address" rows="3" class="form-control @error('address') is-invalid @enderror"
                  placeholder="Staff address...">{{ old('address', $staffMember->address ?? '') }}</textarea>
        @error('address')<div class="invalid-feedback">{{ $message }}</div>@enderror
    </div>

    <div class="col-12">
        <label class="form-label fw-semibold">Profile Photo</label>
        <input type="file" name="profile_photo" class="form-control @error('profile_photo') is-invalid @enderror" accept="image/*">
        @error('profile_photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
        @if(isset($staffMember) && $staffMember->profile_photo_path)
            <div class="mt-2 d-flex align-items-center gap-2">
                <img src="{{ asset('storage/' . $staffMember->profile_photo_path) }}" alt="Photo"
                     class="rounded border" style="width:54px;height:54px;object-fit:cover">
                <span class="text-muted small">Current photo</span>
            </div>
        @endif
    </div>
</div>

