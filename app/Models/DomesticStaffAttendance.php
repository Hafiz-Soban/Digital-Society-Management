<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DomesticStaffAttendance extends Model
{
    protected $fillable = [
        'domestic_staff_id',
        'attendance_date',
        'status',
        'check_in_time',
        'check_out_time',
    ];

    protected $casts = [
        'attendance_date' => 'date',
    ];

    public function domesticStaff(): BelongsTo
    {
        return $this->belongsTo(DomesticStaff::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'present' => '<span class="badge bg-success">Present</span>',
            'absent' => '<span class="badge bg-danger">Absent</span>',
            'leave' => '<span class="badge bg-warning text-dark">Leave</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
