<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Resident extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id', 'house_id', 'resident_id', 'cnic', 'date_of_birth',
        'gender', 'emergency_contact_name', 'emergency_contact_phone',
        'emergency_contact_relation', 'move_in_date', 'move_out_date',
<<<<<<< HEAD
        'ownership_type', 'status', 'family_members', 'notes',
        'due_amount', 'advance_balance',
=======
        'ownership_type', 'status', 'family_members', 'notes', 'due_amount',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'move_in_date' => 'date',
        'move_out_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class);
    }

    public function complaints(): HasMany
    {
        return $this->hasMany(Complaint::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

<<<<<<< HEAD
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    public function trustScore(): HasOne
    {
        return $this->hasOne(TrustScore::class)->latest();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-warning">Inactive</span>',
            'moved_out' => '<span class="badge bg-secondary">Moved Out</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
<<<<<<< HEAD
=======

    public function isRestricted(): bool
    {
        $restrictionEnabled = Setting::get('maintenance_restriction_enabled', '0') === '1';
        return $restrictionEnabled && $this->due_amount > 10000;
    }
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
