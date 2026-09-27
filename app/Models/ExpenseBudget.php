<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseBudget extends Model
{
    protected $fillable = ['month', 'amount'];

    protected $casts = [
        'amount' => 'decimal:2',
    ];
}
