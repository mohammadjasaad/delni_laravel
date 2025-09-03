<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\DatabaseNotification;

class NotificationSeeder extends Seeder
{
    public function run(): void
    {
        // نجيب أول مستخدم Admin
        $admin = User::where('role', 'admin')->first();

        if (!$admin) {
            $this->command->warn('⚠️ لا يوجد مستخدم Admin لإرسال إشعارات.');
            return;
        }

        // إنشاء 5 إشعارات تجريبية
        for ($i = 1; $i <= 5; $i++) {
            DatabaseNotification::create([
                'id' => \Illuminate\Support\Str::uuid()->toString(),
                'type' => 'App\Notifications\GenericNotification',
                'notifiable_type' => User::class,
                'notifiable_id' => $admin->id,
                'data' => [
                    'message' => "🔔 إشعار تجريبي رقم $i",
                ],
                'read_at' => null,
            ]);
        }

        $this->command->info('✅ تم إنشاء 5 إشعارات وهمية للمشرف.');
    }
}
