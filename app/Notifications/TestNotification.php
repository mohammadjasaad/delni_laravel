<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TestNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['database']; // نخزن في قاعدة البيانات
    }

    public function toArray($notifiable)
    {
        return [
            'message' => '✅ هذا إشعار تجريبي',
        ];
    }
}
