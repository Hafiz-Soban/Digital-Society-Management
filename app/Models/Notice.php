<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287

class Notice extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'created_by', 'title', 'content', 'type', 'priority',
        'target_audience', 'is_published', 'publish_at', 'expires_at', 'attachment',
<<<<<<< HEAD
        'target_type', 'target_blocks', 'target_houses', 'target_users',
        'delivery_count', 'read_count'
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'publish_at' => 'datetime',
        'expires_at' => 'datetime',
<<<<<<< HEAD
        'target_blocks' => 'array',
        'target_houses' => 'array',
        'target_users' => 'array',
=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

<<<<<<< HEAD
    public function reads(): HasMany
    {
        return $this->hasMany(NoticeRead::class);
    }

    public function readByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'notice_reads')
            ->withPivot('read_at')
            ->withTimestamps();
    }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
            ->where(function ($q) {
                $q->whereNull('publish_at')->orWhere('publish_at', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            });
    }

    public function getTypeBadgeAttribute(): string
    {
        return match($this->type) {
            'notice' => '<span class="badge bg-primary">Notice</span>',
            'announcement' => '<span class="badge bg-info">Announcement</span>',
            'alert' => '<span class="badge bg-danger">Alert</span>',
            'event' => '<span class="badge bg-success">Event</span>',
<<<<<<< HEAD
            'general' => '<span class="badge bg-secondary">General</span>',
            'maintenance' => '<span class="badge bg-warning">Maintenance</span>',
            'emergency' => '<span class="badge bg-danger">Emergency</span>',
            'rule' => '<span class="badge bg-dark">Rule</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }

    public function getPriorityBadgeAttribute(): string
    {
        return match($this->priority) {
            'low' => '<span class="badge bg-success">Low</span>',
            'normal' => '<span class="badge bg-info">Normal</span>',
            'high' => '<span class="badge bg-warning">High</span>',
            'urgent' => '<span class="badge bg-danger">Urgent</span>',
            default => '<span class="badge bg-secondary">Normal</span>',
        };
    }

    public function isTargetedToUser(User $user): bool
    {
        switch ($this->target_type) {
            case 'all':
            default:
                return true;
            case 'residents':
                return $user->role?->name === 'resident';
            case 'security':
                return $user->role?->name === 'security_guard';
            case 'staff':
                // Check if user is staff (role = maintenance or has staff record?)
                return $user->role?->name === 'maintenance' || Staff::where('email', $user->email)->exists();
            case 'block':
                if (!empty($this->target_blocks)) {
                    $resident = $user->resident;
                    if ($resident && $resident->house && in_array($resident->house->block, $this->target_blocks)) {
                        return true;
                    }
                }
                return false;
            case 'house':
                if (!empty($this->target_houses)) {
                    $resident = $user->resident;
                    if ($resident && $resident->house && in_array($resident->house->id, $this->target_houses)) {
                        return true;
                    }
                }
                return false;
            case 'custom':
                if (!empty($this->target_users) && in_array($user->id, $this->target_users)) {
                    return true;
                }
                // Also check blocks/houses in custom selection
                if (!empty($this->target_blocks)) {
                    $resident = $user->resident;
                    if ($resident && $resident->house && in_array($resident->house->block, $this->target_blocks)) {
                        return true;
                    }
                }
                if (!empty($this->target_houses)) {
                    $resident = $user->resident;
                    if ($resident && $resident->house && in_array($resident->house->id, $this->target_houses)) {
                        return true;
                    }
                }
                return false;
        }
    }
=======
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
}
