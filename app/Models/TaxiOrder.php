<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'pickup_latitude',
        'pickup_longitude',
        'driver_id',
        'status',
    ];

    /**
     * العلاقة مع جدول السائقين
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }
}
