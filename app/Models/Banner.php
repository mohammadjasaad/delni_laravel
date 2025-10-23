<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'image_desktop',
        'image_mobile',
        'link',
        'active',
    ];

    // 🔘 سكوب لإرجاع البانرات المفعلة فقط
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
