<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Complaint extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'resident_id', 'category_id', 'assigned_to', 'complaint_number',
        'title', 'description', 'priority', 'status',
        'resolution_notes', 'resolved_at', 'attachment',
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ComplaintCategory::class, 'category_id');
    }

    public function assignedTo(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function logs(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ComplaintLog::class)->latest();
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'pending' => '<span class="badge bg-danger">Pending</span>',
            'in_progress' => '<span class="badge bg-warning">In Progress</span>',
            'resolved' => '<span class="badge bg-success">Resolved</span>',
            'closed' => '<span class="badge bg-secondary">Closed</span>',
            'escalated' => '<span class="badge bg-dark">Escalated</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => '<span class="badge bg-info">Low</span>',
            'medium' => '<span class="badge bg-warning">Medium</span>',
            'high' => '<span class="badge bg-danger">High</span>',
            'urgent' => '<span class="badge bg-dark">Urgent</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
