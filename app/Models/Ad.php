<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'price', 'city', 'category',
        'images', 'user_id', 'lat', 'lng', 'is_featured'
    ];

    protected $casts = [
        'images'      => 'array',   // ✅ JSON → Array
        'is_featured' => 'boolean',
        'price'       => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}
