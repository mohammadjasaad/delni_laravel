<?php

namespace App\Events;

use App\Models\TaxiMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaxiMessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct(TaxiMessage $message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        return new Channel('taxi-chat.' . $this->message->order_id);
    }

    public function broadcastAs()
    {
        return 'TaxiMessageSent';
    }
}
