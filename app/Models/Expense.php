<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title', 'category', 'amount', 'date', 'reference_no', 'description', 'bill_path'
=======

class Expense extends Model
{
    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $fillable = [
        'title',
        'amount',
        'date',
        'category',
        'description',
        'reference_no',
>>>>>>> a2e8a0c57db7b2f3e6d7ad24acdaf09d65d42287
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];
}
