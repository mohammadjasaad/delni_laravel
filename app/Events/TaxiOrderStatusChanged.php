<?php

namespace App\Events;

use App\Models\TaxiOrder;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaxiOrderStatusChanged implements ShouldBroadcast
{
    use SerializesModels;

    public TaxiOrder $order;

    public function __construct(TaxiOrder $order)
    {
        $this->order = $order->fresh();
    }

    public function broadcastOn()
    {
        return new Channel('taxi-order.'.$this->order->id);
    }

    public function broadcastAs()
    {
        return 'TaxiOrderStatusChanged';
    }
}
