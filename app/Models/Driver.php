<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'car_number',
        'status',
        'latitude',
        'longitude',
        'phone' // تأكد من أن الحقل موجود إذا أضفته للموديل
    ];

    /**
     * العلاقة مع طلبات التاكسي
     */
    public function orders()
    {
        return $this->hasMany(TaxiOrder::class);
    }
}
