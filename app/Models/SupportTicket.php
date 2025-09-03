<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'message',
        'status',
    ];

    /**
     * 🔗 التذكرة مرتبطة بمستخدم واحد
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * 🔗 التذكرة تحتوي عدة ردود
     */
    public function replies()
    {
        return $this->hasMany(SupportTicketReply::class, 'ticket_id');
    }
}
