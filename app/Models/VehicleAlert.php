<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleAlert extends Model
{
    protected $fillable = [
        'vehicle_number', 'alert_type', 'reason',
        'security_guard_id', 'status',
    ];

    public function securityGuard(): BelongsTo
    {
        return $this->belongsTo(User::class, 'security_guard_id');
    }
}
