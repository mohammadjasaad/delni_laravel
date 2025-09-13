<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'city',
        'category',
        'images',
        'user_id',
        'lat',
        'lng',
        'is_featured',
        'slug',
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
