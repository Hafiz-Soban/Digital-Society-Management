<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaintenanceStaff extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'name', 'phone', 'specialization', 'status'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class, 'assigned_staff_id');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'available' => '<span class="badge bg-success">Available</span>',
            'busy' => '<span class="badge bg-warning">Busy</span>',
            'off_duty' => '<span class="badge bg-secondary">Off Duty</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
