<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class GenericNotification extends Notification
{
    use Queueable;

    protected $message;

    /**
     * استلام الرسالة عند إنشاء الإشعار
     */
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**
     * القنوات التي يُرسل إليها الإشعار
     */
    public function via($notifiable)
    {
        // نخليها database فقط (و ممكن Mail/SMS لو حبيت لاحقاً)
        return ['database'];
    }

    /**
     * البيانات اللي تُخزّن في جدول notifications
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
        ];
    }

    /**
     * خيار البريد (لو حبيت ترسل بريد)
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('إشعار جديد')
            ->line($this->message)
            ->action('عرض الحساب', url('/dashboard'))
            ->line('شكراً لاستخدامك دلني!');
    }
}
