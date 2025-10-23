<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'price', 'city', 'category', 'images',
        
        // 🏠 عقارات
        'rooms','bathrooms','area_total','area_net','floor','building_age',
        'has_elevator','has_parking','heating_type','subcategory','property_type',

        // 🚗 سيارات
        'car_model','car_year','car_km','fuel','gearbox','car_color','is_new',

        // 🛠️ خدمات
        'service_type','provider_name','vehicle_type','insurance_type',
        'maintenance_type','bidding_type','support_type',

        // 🌍 الموقع
        'lat','lng',

        // 🔗 العلاقات
        'user_id','store_id',

        // ⭐ مميزات إضافية
        'is_featured','is_urgent','type','slug'
    ];

    protected $casts = [
        'images'      => 'array',   // ✅ JSON → Array
        'is_featured' => 'boolean',
        'is_urgent'   => 'boolean',
        'price'       => 'float',
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

    # ------------------- 📝 Slug -------------------

    // 🟡 إنشاء slug تلقائي عند الإنشاء فقط
    protected static function booted()
    {
        static::creating(function ($ad) {
            if (empty($ad->slug)) {
                $ad->slug = Str::slug($ad->title) . '-' . Str::random(6);
            }
        });
    }
}
