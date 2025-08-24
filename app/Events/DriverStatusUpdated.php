<?php

namespace App\Events;

use App\Models\Driver;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class DriverStatusUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $id;
    public string $name;
    public ?string $car_number;
    public string $status;
    public ?float $lat;
    public ?float $lng;
    public ?string $updated_at;

    public function __construct(Driver $driver)
    {
        $lat = $driver->lat ?? $driver->latitude ?? null;
        $lng = $driver->lng ?? $driver->lon ?? $driver->longitude ?? null;

        $this->id         = (int) $driver->id;
        $this->name       = (string) ($driver->name ?? 'سائق');
        $this->car_number = $driver->car_number ?? null;
        $this->status     = (string) ($driver->status ?? 'غير معروف');
        $this->lat        = $lat !== null ? (float) $lat : null;
        $this->lng        = $lng !== null ? (float) $lng : null;
        $this->updated_at = optional($driver->updated_at)->toISOString();
    }

    public function broadcastOn(): Channel
    {
        // قناة عامة كما يستخدمها الـ Blade: window.Echo.channel('drivers')
        return new Channel('drivers');
    }

    public function broadcastAs(): string
    {
        // في الواجهة نستمع على '.DriverStatusUpdated'
        return 'DriverStatusUpdated';
    }
}
