<?php

namespace App\Events;

use App\Models\Driver;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverLocationUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int|string $driverId;
    public int|string|null $orderId = null;
    public float $latitude;
    public float $longitude;
    public string $status;
    public string $updatedAt;

    // بيانات اختيارية للواجهة
    public ?string $name = null;
    public ?string $carNumber = null;

    /**
     * يدعم أسلوبين:
     * 1) القديم:  (driverId, latitude, longitude, status?)
     * 2) الجديد:  (driverId, orderId, latitude, longitude, status?)
     */
    public function __construct($driverId, ...$args)
    {
        $this->driverId = $driverId;

        // كشف التوقيع المستخدم
        if (isset($args[0], $args[1]) && is_numeric($args[0]) && is_numeric($args[1])) {
            // التوقيع القديم: lat, lng, [status]
            $this->orderId   = null;
            $this->latitude  = (float) $args[0];
            $this->longitude = (float) $args[1];
            $this->status    = (string)($args[2] ?? 'متاح');
        } else {
            // التوقيع الجديد: orderId, lat, lng, [status]
            $this->orderId   = $args[0] ?? null;
            $this->latitude  = (float) ($args[1] ?? 0);
            $this->longitude = (float) ($args[2] ?? 0);
            $this->status    = (string)($args[3] ?? 'متاح');
        }

        $this->updatedAt = now()->toISOString();

        // معلومات إضافية للواجهة (إن وجدت)
        if ($driver = Driver::find($this->driverId)) {
            $this->name      = $driver->name;
            $this->carNumber = $driver->car_number;
        }
    }

    /**
     * قنوات البث: عامة + خاصة بالطلب (إن توفرت)
     */
    public function broadcastOn(): array
    {
        $channels = [ new Channel('drivers') ];

        if (!empty($this->orderId)) {
            $channels[] = new Channel("driver.location.{$this->orderId}");
        }

        return $channels;
    }

    /**
     * اسم الحدث الذي تسمعه الواجهة
     * (متوافق مع صفحة الخريطة الحالية)
     */
    public function broadcastAs(): string
    {
        return 'DriverStatusUpdated';
    }

    /**
     * الحمولة المرسلة – تضم مفاتيح قديمة وحديثة للتوافق
     */
    public function broadcastWith(): array
    {
        return [
            // معرفات
            'id'         => $this->driverId,          // متوافق مع الواجهة الحالية
            'driver_id'  => $this->driverId,
            'order_id'   => $this->orderId,

            // الإحداثيات (النسختان)
            'lat'        => $this->latitude,
            'lng'        => $this->longitude,
            'latitude'   => $this->latitude,
            'longitude'  => $this->longitude,

            // الحالة والتوقيت
            'status'     => $this->status,
            'updated_at' => $this->updatedAt,

            // معلومات إضافية (إن وُجدت)
            'name'       => $this->name,
            'car_number' => $this->carNumber,
        ];
    }
}
