<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class DomesticStaff extends Model
{
    use SoftDeletes;

    protected $table = 'domestic_staff';

    protected $fillable = [
        'resident_id',
        'name',
        'cnic',
        'mobile',
        'staff_type',
        'joining_date',
        'status',
        'address',
        'emergency_contact',
        'profile_photo_path',
        'qr_token',
    ];

    protected $casts = [
        'joining_date' => 'date',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(DomesticStaffAttendance::class)->latest('attendance_date');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-secondary">Inactive</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}

