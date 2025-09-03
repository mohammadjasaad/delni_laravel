<?php

namespace App\Notifications;

use App\Models\SupportTicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SupportTicketReplyNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $reply;

    public function __construct(SupportTicketReply $reply)
    {
        $this->reply = $reply;
    }

    /**
     * القنوات المستخدمة
     */
    public function via($notifiable)
    {
        return ['database']; // يمكن إضافة 'mail' لاحقاً
    }

    /**
     * رسالة البريد الإلكتروني (لو فعلنا mail)
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('📩 رد جديد على التذكرة #' . $this->reply->ticket_id)
            ->line('قام ' . ($this->reply->user->name ?? 'مستخدم') . ' بالرد:')
            ->line($this->reply->message)
            ->action('عرض التذكرة', url('/support/' . $this->reply->ticket_id))
            ->line('شكراً لاستخدامك نظام الدعم الفني.');
    }

    /**
     * التخزين في قاعدة البيانات
     */
    public function toArray($notifiable)
    {
        return [
            'message'   => "📩 رد جديد على التذكرة #{$this->reply->ticket_id} من " . ($this->reply->user->name ?? 'مستخدم') . ": {$this->reply->message}",
            'ticket_id' => $this->reply->ticket_id,
            'reply_id'  => $this->reply->id,
            'user_id'   => $this->reply->user_id,
        ];
    }
}
