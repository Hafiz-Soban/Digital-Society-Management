<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmergencyAlert extends Model
{
    protected $fillable = [
        'created_by', 'title', 'description', 'type', 'severity',
        'status', 'location', 'resolved_at', 'resolution_notes',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function getSeverityBadgeAttribute(): string
    {
        return match($this->severity) {
            'low' => '<span class="badge bg-info">Low</span>',
            'medium' => '<span class="badge bg-warning">Medium</span>',
            'high' => '<span class="badge bg-danger">High</span>',
            'critical' => '<span class="badge bg-dark">Critical</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => '<span class="badge bg-danger">Active</span>',
            'resolved' => '<span class="badge bg-success">Resolved</span>',
            'false_alarm' => '<span class="badge bg-secondary">False Alarm</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
