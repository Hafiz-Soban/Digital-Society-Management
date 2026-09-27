<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaintenancePayment extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'resident_id', 'house_id', 'amount', 'payment_date',
        'payment_method', 'reference_number', 'notes',
    ];

    protected $casts = [
        'payment_date' => 'date',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function house(): BelongsTo
    {
        return $this->belongsTo(House::class);
    }
}
