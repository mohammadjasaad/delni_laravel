<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\NewSupportTicketNotification;

class SupportTicketController extends Controller
{
    // ✅ عرض كل التذاكر الخاصة بالمستخدم
    public function index()
    {
        $tickets = SupportTicket::where('user_id', auth()->id())
                                ->latest()
                                ->get();

        return view('dashboard.support.index', compact('tickets'));
    }

    // ✅ عرض نموذج إنشاء تذكرة
    public function create()
    {
        return view('dashboard.support.create');
    }

    // ✅ حفظ تذكرة جديدة وإشعار المدراء
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

        // إرسال إشعار لجميع المدراء
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewSupportTicketNotification($ticket));
        }

        return redirect()->route('support.index')->with('success', '✅ تم إرسال التذكرة بنجاح.');
    }

    // ✅ عرض تفاصيل التذكرة الخاصة بالمستخدم
    public function show($id)
    {
        $ticket = SupportTicket::where('id', $id)
                    ->where('user_id', auth()->id())
                    ->firstOrFail();

        return view('dashboard.support.show', compact('ticket'));
    }

    // ✅ عرض إحصائيات التذاكر للمشرف
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
