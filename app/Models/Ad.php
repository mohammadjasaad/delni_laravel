<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'is_featured', // ✅ أضفنا هذا الحقل لدعمه في عمليات create/update
    ];

    protected $casts = [
        'is_featured' => 'boolean', // ✅ نحوله إلى true/false تلقائيًا
    ];

    // 🔗 العلاقة مع المستخدم
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}

