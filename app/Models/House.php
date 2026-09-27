<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class House extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'house_number', 'block', 'floor', 'bedrooms',
<<<<<<< HEAD
        'area_sqft', 'status', 'description',
=======
        'area_sqft', 'monthly_maintenance', 'status', 'description',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        'is_rented', 'tenant_name', 'tenant_father_name', 'tenant_cnic',
        'tenant_contact', 'rent_agreement_path', 'rent_agreement_status',
        'owner_name', 'owner_cnic', 'owner_phone',
    ];

    public function residents(): HasMany
    {
        return $this->hasMany(Resident::class);
    }

    public function currentResident(): HasOne
    {
        return $this->hasOne(Resident::class)->where('status', 'active');
    }

    public function maintenanceRequests(): HasMany
    {
        return $this->hasMany(MaintenanceRequest::class);
    }

<<<<<<< HEAD
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

=======
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    public function getFullAddressAttribute(): string
    {
        $parts = [$this->house_number];
        if ($this->block) $parts[] = 'Block ' . $this->block;
        if ($this->floor) $parts[] = 'Floor ' . $this->floor;
        return implode(', ', $parts);
    }

    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'occupied' => '<span class="badge bg-success">Occupied</span>',
            'vacant' => '<span class="badge bg-warning">Vacant</span>',
            'under_maintenance' => '<span class="badge bg-danger">Under Maintenance</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
    }
}
