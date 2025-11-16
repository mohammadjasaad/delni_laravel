<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'subcategory',
        'user_id',
        'name',
        'stars',
        'comment',
    ];

    // 🔗 كل تقييم مربوط بمستخدم (الذي قام بالتقييم)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
