<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketAdminController extends Controller
{
    // ✅ عرض جميع التذاكر
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->paginate(15);
        return view('admin.support_tickets.index', compact('tickets'));
    }

    // ✅ عرض تذكرة واحدة
    public function show($id)
    {
        $ticket = SupportTicket::with('user')->findOrFail($id);
        return view('admin.support_tickets.show', compact('ticket'));
    }

    // ✅ تحديث حالة التذكرة
public function update(Request $request, $id)
{
    $ticket = SupportTicket::findOrFail($id);

    $request->validate([
        'status' => 'required|string',
        'reply' => 'nullable|string',
    ]);

    $ticket->status = $request->status;
    $ticket->reply = $request->reply;
    $ticket->save();

    return redirect()->route('admin.support_tickets.show', $ticket->id)
                     ->with('success', 'تم تحديث التذكرة بنجاح.');
}

}
