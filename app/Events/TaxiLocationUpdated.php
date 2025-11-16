<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaxiLocationUpdated implements ShouldBroadcast
{
    use SerializesModels;

    public int $orderId;
    public float $lat;
    public float $lng;
    public ?int $driverId;

    public function __construct(int $orderId, float $lat, float $lng, ?int $driverId)
    {
        $this->orderId = $orderId;
        $this->lat = $lat;
        $this->lng = $lng;
        $this->driverId = $driverId;
    }

    public function broadcastOn()
    {
        return new Channel('taxi-order.'.$this->orderId);
    }

    public function broadcastAs()
    {
        return 'TaxiLocationUpdated';
    }
}
