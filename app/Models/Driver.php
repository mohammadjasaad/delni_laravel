<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // يجعل Driver قابل للمصادقة
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;

class Driver extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'drivers'; // جدول السائقين

    protected $fillable = [
        'name',
        'phone',
        'car_number',
        'status',
        'latitude',
        'longitude',
        'is_active',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * العلاقة مع طلبات التاكسي
     */
    public function orders()
    {
        return $this->hasMany(TaxiOrder::class);
    }

    /**
     * ✅ تأكد أن الـ guard الخاص بالسائق
     */
    public function guardName(): string
    {
        return 'driver';
    }
}
