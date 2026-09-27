<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Visitor extends Model
{
<<<<<<< HEAD
    use SoftDeletes;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    protected $fillable = [
        'resident_id', 'approved_by', 'visitor_name', 'visitor_phone',
        'visitor_cnic', 'vehicle_number', 'purpose', 'status',
        'expected_arrival', 'actual_arrival', 'departure_time',
        'otp', 'otp_expires_at', 'notes', 'photo',
    ];

    protected $casts = [
        'expected_arrival' => 'datetime',
        'actual_arrival' => 'datetime',
        'departure_time' => 'datetime',
        'otp_expires_at' => 'datetime',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function securityLogs(): HasMany
    {
        return $this->hasMany(SecurityLog::class);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-warning">Pending</span>',
            'approved' => '<span class="badge bg-success">Approved</span>',
            'denied' => '<span class="badge bg-danger">Denied</span>',
            'checked_in' => '<span class="badge bg-info">Checked In</span>',
            'checked_out' => '<span class="badge bg-secondary">Checked Out</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
