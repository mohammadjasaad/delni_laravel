<?php

namespace App\Events;

use App\Models\TaxiMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class TaxiMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    /**
     * إنشاء الحدث الجديد
     */
    public function __construct(TaxiMessage $message)
    {
        $this->message = $message;
    }

    /**
     * القناة التي سيتم بث الحدث عليها
     */
    public function broadcastOn()
    {
        // قناة مخصصة لكل طلب تاكسي حسب الـ order_id
        return new Channel('taxi-chat.' . $this->message->order_id);
    }

    /**
     * اسم الحدث الذي سيتم بثّه في الواجهة
     */
    public function broadcastAs()
    {
        return 'TaxiMessageSent';
    }

    /**
     * البيانات التي سيتم إرسالها إلى المتصفح عبر Pusher
     */
    public function broadcastWith()
    {
        return [
            'id'          => $this->message->id,
            'order_id'    => $this->message->order_id,
            'sender_type' => $this->message->sender_type,
            'sender_id'   => $this->message->sender_id,
            'message'     => $this->message->message,
            'created_at'  => $this->message->created_at->toDateTimeString(),
        ];
    }
}
