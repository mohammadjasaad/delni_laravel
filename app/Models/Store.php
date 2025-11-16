<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

protected $fillable = [
    'name',
    'category',
    'description',
    'logo',       // ✅ أضف هذا السطر
    'user_id',
    'status',
];

    # 🔗 علاقة المتجر مع الإعلانات
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    # ❤️ علاقة المفضلة (عبر الإعلانات)
    public function favorites()
    {
        return $this->hasManyThrough(
            Favorite::class, // الجدول النهائي
            Ad::class,       // الجدول الوسيط
            'store_id',      // المفتاح الأجنبي في جدول ads
            'ad_id',         // المفتاح الأجنبي في جدول favorites
            'id',            // المفتاح المحلي للمتجر
            'id'             // المفتاح المحلي للإعلان
        );
    }

    # ------------------- 📊 الإحصائيات -------------------
    # عدد الإعلانات الكلي
    public function getAdsCountAttribute()
    {
        return $this->ads()->count();
    }

    # عدد الإعلانات المميزة
    public function getFeaturedAdsCountAttribute()
    {
        return $this->ads()->where('is_featured', 1)->count();
    }

    # عدد الإعلانات العادية
    public function getNormalAdsCountAttribute()
    {
        return $this->ads()->where('is_featured', 0)->count();
    }

    # عدد الإعلانات العاجلة
    public function getUrgentAdsCountAttribute()
    {
        return $this->ads()->where('is_urgent', 1)->count();
    }

    # عدد طلبات الإعلانات (مثلاً سيارات مطلوبه)
    public function getRequestedAdsCountAttribute()
    {
        return $this->ads()->where('type', 'request')->count();
    }

    # عدد المفضلة
    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();

    }
# 🔗 علاقة المتجر مع المنتجات
public function products()
{
    return $this->hasMany(Product::class);
}
    // ✅ تعريف المفتاح المستخدم في Route Model Binding
    public function getRouteKeyName()
    {
        return 'id';
    }

}
