<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewSupportTicketNotification;

class SupportTicketController extends Controller
{
    /**
     * ✅ عرض كل التذاكر الخاصة بالمستخدم
     */
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('dashboard.support.index', compact('tickets'));
    }

    /**
     * ✅ عرض نموذج إنشاء تذكرة
     */
    public function create()
    {
        return view('dashboard.support.create');
    }

    /**
     * ✅ حفظ تذكرة جديدة + إشعار المشرفين
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        $ticket = SupportTicket::create([
            'user_id' => auth()->id(),
            'subject' => $request->subject,
            'message' => $request->message,
            'status'  => 'جديد',
        ]);

        // 📩 إرسال إشعار لجميع المشرفين
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewSupportTicketNotification($ticket));
        }

        return redirect()->route('support.index')
                         ->with('success', __('messages.ticket_created_successfully') ?? '✅ تم إرسال التذكرة بنجاح.');
    }

    /**
     * ✅ عرض تفاصيل التذكرة (مع الردود)
     */
    public function show($id)
    {
        $ticket = SupportTicket::with('replies.user') // يجلب الردود مع صاحب الرد
                    ->where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        return view('dashboard.support.show', compact('ticket'));
    }

// ✅ إضافة رد على التذكرة
public function reply(Request $request, $id)
{
    $request->validate([
        'message' => 'required|string',
    ]);

    $ticket = SupportTicket::with('user')
                ->where('id', $id)
                ->firstOrFail();

    $reply = SupportTicketReply::create([
        'ticket_id' => $ticket->id,
        'user_id'   => auth()->id(),
        'message'   => $request->message,
    ]);

    // 🟡 تحديث حالة التذكرة حسب نوع المرسل
    if (auth()->user()->role === 'admin') {
        $ticket->update(['status' => 'تم الرد']); // رد من المشرف
        $ticket->user->notify(new \App\Notifications\SupportTicketReplyNotification($reply));
    } else {
        $ticket->update(['status' => 'قيد المعالجة']); // رد من المستخدم
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new \App\Notifications\SupportTicketReplyNotification($reply));
        }
    }

    return redirect()->route('support.show', $ticket->id)
        ->with('success', '✅ تم إرسال ردك بنجاح.');
}

    /**
     * ✅ إحصائيات التذاكر (لوحة المشرف)
     */
    public function statistics()
    {
        $total      = SupportTicket::count();
        $new        = SupportTicket::where('status', 'جديد')->count();
        $processing = SupportTicket::where('status', 'قيد المعالجة')->count();
        $answered   = SupportTicket::where('status', 'تم الرد')->count();
        $closed     = SupportTicket::where('status', 'مغلق')->count();

        return view('admin.support_tickets.statistics', compact(
            'total', 'new', 'processing', 'answered', 'closed'
        ));
    }
}
