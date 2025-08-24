<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $table = 'ratings';

    protected $fillable = [
        'driver_id',
        'order_id',
        'driver_name',
        'rating',
        'stars',     // ✅ أضفناه
        'comment',
    ];

    protected $casts = [
        'driver_id' => 'integer',
        'order_id'  => 'integer',
        'rating'    => 'float',
        'stars'     => 'integer', // ✅ تحويل
    ];
}
