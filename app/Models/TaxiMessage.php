<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxiMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'sender_type', // user أو driver
        'message',
    ];

    /**
     * العلاقة مع الطلب
     */
    public function order()
    {
        return $this->belongsTo(TaxiOrder::class, 'order_id');
    }
}
