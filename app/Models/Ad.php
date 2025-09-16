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
        'rooms','bathrooms','area_total','area_net','floor','building_age','has_elevator','has_parking','heating_type','subcategory',
        
        // 🚗 سيارات
        'car_model','car_year','car_km','fuel','gearbox','car_color','is_new',
        
        // 🛠️ خدمات
        'service_type','provider_name',
        
        // 🌍 الموقع
        'lat','lng',
        'user_id',
        
        // 🛠️ خدمات إضافية
        'vehicle_type','insurance_type','maintenance_type',
        'property_type','bidding_type','support_type',
        
        // ⭐ مميزات إضافية
        'is_featured','slug'
    ];

    protected $casts = [
        'images'      => 'array',   // ✅ JSON → Array
        'is_featured' => 'boolean',
        'price'       => 'float',
    ];

    // 🟡 علاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🟡 علاقة مع المفضلة
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

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
