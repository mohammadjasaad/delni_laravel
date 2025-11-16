<?php

namespace App\Events;

use App\Models\Driver;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TaxiDriverLocationUpdated implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $driver;

    public function __construct(Driver $driver)
    {
        $this->driver = $driver;
    }

    public function broadcastOn()
    {
        return new Channel('taxi-driver.' . $this->driver->id);
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }
}
