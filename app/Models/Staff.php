<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Staff extends Model
{
    use SoftDeletes;

    protected $table = 'staff';

    protected $fillable = [
        'employee_id', 'full_name', 'father_name', 'email', 'phone_number',
        'alternate_phone', 'cnic', 'dob', 'gender', 'address', 'photo_path',
        'designation', 'joining_date', 'salary', 'shift_timing', 'status',
        'emergency_name', 'emergency_phone', 'emergency_relation'
    ];

    protected $casts = [
        'dob' => 'date',
=======

class Staff extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation',
        'salary',
        'joining_date',
        'address',
        'status',
    ];

    protected $casts = [
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
        'joining_date' => 'date',
        'salary' => 'decimal:2',
    ];

<<<<<<< HEAD
    public function attendance(): HasMany
    {
        return $this->hasMany(StaffAttendance::class);
    }

    public function salaries(): HasMany
    {
        return $this->hasMany(StaffSalary::class);
    }

    public function advances(): HasMany
    {
        return $this->hasMany(StaffAdvance::class);
    }

    public function getTotalAdvancesAttribute()
    {
        return $this->advances()->sum('amount');
    }

    public function getRemainingSalaryAttribute()
    {
        // This is usually calculated per month, but for a quick profile view:
        return $this->salary - $this->getTotalAdvancesAttribute();
=======
    public function getStatusBadgeAttribute(): string
    {
        return match($this->status) {
            'active' => '<span class="badge bg-success">Active</span>',
            'inactive' => '<span class="badge bg-danger">Inactive</span>',
            default => '<span class="badge bg-secondary">Unknown</span>',
        };
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    }
}
