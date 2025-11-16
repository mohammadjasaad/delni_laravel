<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiOrder extends Model
{
    use HasFactory;

protected $fillable = [
    'user_id',
    'driver_id',

    // ✅ مواقع الالتقاط
    'pickup_latitude',
    'pickup_longitude',

    // ✅ موقع الوجهة
    'dropoff_latitude',
    'dropoff_longitude',

    // ✅ حالة الطلب
    'status',

    // ✅ تقييم بعد نهاية الرحلة
    'rating',

    // ✅ ميزات جديدة
    'distance_km',      // المسافة بالكيلومتر
    'fare_syp',        // السعر النهائي بالليرة السورية
    'route_polyline',  // مسار الرحلة (حفظه كـ JSON string)
];

    /**
     * العلاقة مع السائق
     */
    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    /**
     * العلاقة مع الرسائل
     */
    public function messages()
    {
        return $this->hasMany(TaxiMessage::class, 'order_id');
    }
}
