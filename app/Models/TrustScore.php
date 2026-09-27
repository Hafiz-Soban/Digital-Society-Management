<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TrustScore extends Model
{
    protected $fillable = ['resident_id', 'score', 'reason', 'updated_by'];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getScoreBadgeAttribute(): string
    {
        if ($this->score >= 80) return '<span class="badge bg-success">' . $this->score . '</span>';
        if ($this->score >= 60) return '<span class="badge bg-warning">' . $this->score . '</span>';
        return '<span class="badge bg-danger">' . $this->score . '</span>';
    }
}
