<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use App\Models\SupportTicketReply;
use Illuminate\Http\Request;
use App\Notifications\SupportTicketReplyNotification;

class SupportTicketAdminController extends Controller
{
    // ✅ عرض جميع التذاكر
    public function index()
    {
        $tickets = SupportTicket::with('user')
            ->orderBy("created_at", "desc")
            ->paginate(15);

        return view('admin.support_tickets.index', compact('tickets'));
    }

    // ✅ عرض تذكرة واحدة
    public function show($id)
    {
        $ticket = SupportTicket::with(['user', 'replies.user'])->findOrFail($id);
        return view('admin.support_tickets.show', compact('ticket'));
    }

    // ✅ تحديث حالة التذكرة + إضافة رد
    public function update(Request $request, $id)
    {
        $ticket = SupportTicket::with('user')->findOrFail($id);

        $request->validate([
            'status' => 'required|string',
            'reply'  => 'nullable|string',
        ]);

        // تحديث الحالة
        $ticket->status = $request->status;
        $ticket->save();

        // إذا فيه رد جديد
        if ($request->filled('reply')) {
            $reply = SupportTicketReply::create([
                'ticket_id' => $ticket->id,
                'user_id'   => auth()->id(), // المشرف الحالي
                'message'   => $request->reply,
            ]);

            // إرسال إشعار لصاحب التذكرة
            if ($ticket->user) {
                $ticket->user->notify(new SupportTicketReplyNotification($reply));
            }
        }

        return redirect()->route('admin.support_tickets.show', $ticket->id)
                         ->with('success', '✅ تم تحديث التذكرة وإضافة الرد (إن وجد).');
    }

// ✅ إحصائيات التذاكر
public function statistics()
{
    $total      = SupportTicket::count();
    $new        = SupportTicket::where('status', 'جديد')->count();
    $processing = SupportTicket::where('status', 'قيد المعالجة')->count();
    $answered   = SupportTicket::where('status', 'تم الرد')->count();
    $closed     = SupportTicket::where('status', 'مغلق')->count();

    // 🔥 آخر 5 تذاكر
    $latestTickets = SupportTicket::with('user')
        ->orderBy('created_at', 'desc')
        ->limit(5)
        ->get();

    return view('admin.support_tickets.statistics', compact(
        'total',
        'new',
        'processing',
        'answered',
        'closed',
        'latestTickets'
    ));
}

}
