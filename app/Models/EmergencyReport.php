<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'emergency_service_id',
        'user_id',
        'reason',
        'status',
    ];

    /**
     * 🔗 البلاغ يخص مركز طوارئ
     */
    public function service()
    {
        return $this->belongsTo(EmergencyService::class, 'emergency_service_id');
    }

    /**
     * 🔗 البلاغ يخص مستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
