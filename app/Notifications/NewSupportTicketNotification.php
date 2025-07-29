namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\SupportTicket;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewSupportTicketNotification extends Notification
{
    use Queueable;

    public $ticket;

    public function __construct(SupportTicket $ticket)
    {
        $this->ticket = $ticket;
    }

    public function via($notifiable)
    {
        return ['database']; // يمكن لاحقًا إضافة 'mail'
    }

    public function toDatabase($notifiable)
    {
        return [
            'id' => $this->ticket->id,
            'subject' => $this->ticket->subject,
            'user_name' => $this->ticket->user->name ?? 'مستخدم غير معروف',
            'created_at' => $this->ticket->created_at->format('Y-m-d H:i'),
        ];
    }
}
