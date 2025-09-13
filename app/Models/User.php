<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    // 🟡 الحقول القابلة للتعبئة
    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'role', // 🆕 (user / admin)
        'phone',
        'avatar',
    ];

    // 🟡 الحقول المخفية
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 🟡 التحويلات
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    // 🏠 إعلانات
    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    // ❤️ المفضلة
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    // 🚖 الطلبات
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // 🚨 بلاغات الطوارئ
    public function emergencyReports()
    {
        return $this->hasMany(EmergencyReport::class);
    }

    // 🎫 تذاكر الدعم الفني
    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class, 'user_id');
    }

    // 💬 ردود التذاكر
    public function supportTicketReplies()
    {
        return $this->hasMany(SupportTicketReply::class, 'user_id');
    }

    // 🔔 إشعارات
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notifiable');
    }

    // 🆔 التحقق من الدور
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
