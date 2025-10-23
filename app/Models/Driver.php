<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Driver extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'car_number',
        'car_model',
        'latitude',
        'longitude',
        'status', // available | busy | offline
    ];

    protected $hidden = [
        'password',
    ];

    /**
     * العلاقة مع طلبات التاكسي
     */
    public function orders()
    {
        return $this->hasMany(TaxiOrder::class);
    }
}
