<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityIncident extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reported_by', 'title', 'type', 'description', 'location', 'image', 'status', 'resolved_at', 'resolution_notes'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function reporter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'reported' => '<span class="badge bg-danger">Reported</span>',
            'under_review' => '<span class="badge bg-warning">Under Review</span>',
            'resolved' => '<span class="badge bg-success">Resolved</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getTypeLabelAttribute(): string
    {
        return str_replace('_', ' ', ucfirst($this->type));
    }
}
