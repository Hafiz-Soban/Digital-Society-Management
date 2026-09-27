<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleLog extends Model
{
    protected $fillable = [
        'vehicle_id', 'vehicle_number', 'house_id', 'driver_name',
        'entry_time', 'exit_time', 'entry_status', 'security_guard_id',
    ];

    protected $casts = [
        'entry_time' => 'datetime',
        'exit_time' => 'datetime',
    ];

    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }

    public function securityGuard(): BelongsTo
    {
        return $this->belongsTo(User::class, 'security_guard_id');
    }
}
