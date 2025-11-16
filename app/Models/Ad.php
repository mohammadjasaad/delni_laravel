<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ad extends Model
{
    use HasFactory;

protected $fillable = [
    // أساسي
    'title', 'description', 'price', 'currency', 'city', 'category', 'images',
    'deal_type', 'type', 'slug', 'reference',

    // 🔗 علاقات
    'user_id','store_id',

    // ⭐ ميزات
    'is_featured','is_urgent',

    // 🌍 موقع
    'lat','lng',

    // 🏠 عقارات
    'rooms','bathrooms','area_total','area_net','floor','building_age',
    'has_elevator','has_parking','heating_type','subcategory','property_type',

    // 🚗 سيارات (هنا كان الخطأ ‼️)
    'car_brand','car_model','car_year','car_km','fuel','gearbox','car_color',
    'engine_size','doors','body_type','is_new',

    // 🛠 خدمات
    'service_type','provider_name','vehicle_type','insurance_type',
    'maintenance_type','bidding_type','support_type',

    // 📞 رقم التواصل ← ✅ أضف هذا
    'phone',
];

protected $casts = [
    'images'       => 'array',
    'is_featured'  => 'boolean',
    'is_urgent'    => 'boolean',
    'has_elevator' => 'boolean',
    'has_parking'  => 'boolean',
    'is_new'       => 'boolean',
    'price'        => 'float',
    'lat'          => 'float',
    'lng'          => 'float',
    'car_km'       => 'integer',
    'engine_size'  => 'integer',
    'doors'        => 'integer',
];

    # ------------------- 🔗 العلاقات -------------------

    // 🟡 علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🟡 علاقة مع المتجر
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    // 🟡 علاقة مع المفضلة
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    # ------------------- 📊 Scopes -------------------

    // إعلانات مميزة
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', 1);
    }

    // إعلانات عاجلة
    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', 1);
    }

    // إعلانات طلب
    public function scopeRequests($query)
    {
        return $query->where('type', 'request');
    }

    // إعلانات عروض
    public function scopeOffers($query)
    {
        return $query->where('type', 'offer');
    }

    // فلترة حسب المدينة
    public function scopeByCity($query, $city)
    {
        return $query->where('city', $city);
    }

    // فلترة حسب التصنيف
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

public function ratings()
{
    return $this->hasMany(Rating::class);
}

    # ------------------- 📝 Slug -------------------

    // 🟡 إنشاء slug تلقائي عند الإنشاء فقط
protected static function booted()
{
    static::creating(function ($ad) {
        // ✅ إنشاء slug تلقائي إذا لم يكن موجودًا
        if (empty($ad->slug)) {
            $ad->slug = \Str::slug($ad->title) . '-' . \Str::random(6);
        }

        // ✅ توليد رقم تسلسلي فريد للإعلان
        $lastId = \App\Models\Ad::max('id') + 1;
        $ad->reference = now()->format('Ymd') . str_pad($lastId, 4, '0', STR_PAD_LEFT);
    });
}

}
