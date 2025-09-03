<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicketReply extends Model
{
    use HasFactory;

    protected $fillable = [
        'ticket_id',
        'user_id',
        'message',
    ];

    /**
     * 🔗 الرد يخص تذكرة
     */
    public function ticket()
    {
        return $this->belongsTo(SupportTicket::class, 'ticket_id');
    }

    /**
     * 🔗 الرد يخص مستخدم (الكاتب)
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
