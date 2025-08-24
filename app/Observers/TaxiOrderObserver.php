<?php

namespace App\Observers;

use App\Models\TaxiOrder;
use App\Models\Driver;
use App\Events\DriverStatusUpdated;

class TaxiOrderObserver
{
    public function saved(TaxiOrder $order): void
    {
        if (!$order->driver_id) {
            return;
        }

        $targetStatus = $this->driverStatusForOrder($order->status);
        if (!$targetStatus) {
            return;
        }

        $driver = Driver::find($order->driver_id);
        if ($driver && $driver->status !== $targetStatus) {
            $driver->status = $targetStatus;
            $driver->save();

            // بثّ الحدث فورًا بعد تحديث السائق
            event(new DriverStatusUpdated($driver));
        }
    }

    protected function driverStatusForOrder(?string $orderStatus): ?string
    {
        if (!$orderStatus) return null;

        $s = mb_strtolower(trim($orderStatus));
        $mapIn = [
            'قيد الانتظار' => 'pending',
            'مقبول'       => 'accepted',
            'في الطريق'    => 'en_route',
            'بدأ'          => 'started',
            'بدأت'         => 'started',
            'مكتمل'       => 'completed',
            'منتهي'        => 'completed',
            'ملغي'         => 'cancelled',
            'أُلغي'        => 'cancelled',
            'الغاء'        => 'cancelled',
        ];
        $s = $mapIn[$s] ?? $s;

        if (in_array($s, ['accepted', 'en_route', 'started'], true)) return 'مشغول';
        if (in_array($s, ['completed', 'cancelled'], true))        return 'متاح';

        return null; // pending/أخرى: لا تغيير
    }
}
