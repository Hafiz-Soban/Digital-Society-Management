<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityLog extends Model
{
<<<<<<< HEAD
    use SoftDeletes;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    protected $fillable = [
        'logged_by', 'visitor_id', 'event_type', 'description', 'location', 'severity',
    ];

    public function loggedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'logged_by');
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class);
    }

    public function getSeverityBadgeAttribute(): string
    {
        return match($this->severity) {
            'info' => '<span class="badge bg-info">Info</span>',
            'warning' => '<span class="badge bg-warning">Warning</span>',
            'critical' => '<span class="badge bg-danger">Critical</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
