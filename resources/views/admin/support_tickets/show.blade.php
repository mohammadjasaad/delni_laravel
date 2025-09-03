{{-- resources/views/admin/support_tickets/show.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-3xl mx-auto py-10 px-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">📄 تفاصيل التذكرة #{{ $ticket->id }}</h1>

        {{-- ✅ بيانات التذكرة --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4 text-gray-700">
            <div><strong>👤 المستخدم:</strong> {{ $ticket->user->name ?? 'غير معروف' }}</div>
            <div><strong>📧 البريد:</strong> {{ $ticket->user->email ?? '-' }}</div>
            <div><strong>📝 الموضوع:</strong> {{ $ticket->subject }}</div>
            <div><strong>💬 الرسالة:</strong>
                <div class="bg-gray-100 p-4 rounded mt-2 whitespace-pre-wrap">{{ $ticket->message }}</div>
            </div>
            <div><strong>📅 تم الإرسال في:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</div>
        </div>

        {{-- 💬 الردود --}}
        <div class="bg-white shadow rounded-lg p-6 mt-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">💬 الردود</h2>

            {{-- ✅ عرض الردود إن وجدت --}}
            @if($ticket->replies->count() > 0)
                <div class="space-y-4 mb-6">
                    @foreach($ticket->replies as $reply)
                        <div class="p-4 rounded-lg 
                            {{ $reply->user && $reply->user->role === 'admin' 
                                ? 'bg-yellow-50 border border-yellow-300 text-gray-800' 
                                : 'bg-gray-100 text-gray-700' }}">
                            <p class="text-sm">{{ $reply->message }}</p>
                            <small class="text-gray-500 flex justify-between">
                                <span>👤 {{ $reply->user->name ?? 'مستخدم' }}</span>
                                <span>📅 {{ $reply->created_at->format('Y-m-d H:i') }}</span>
                            </small>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 mb-6">🔕 {{ __('messages.no_replies') }}</p>
            @endif

            {{-- 📝 إضافة رد جديد + تحديث الحالة --}}
            <form method="POST" action="{{ route('admin.support_tickets.update', $ticket->id) }}" class="space-y-4">
                @csrf
                @method('PUT')

                {{-- 🔁 تحديث الحالة --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">🔁 تحديث الحالة:</label>
                    <select name="status" class="border rounded px-3 py-2 w-full max-w-sm">
                        <option value="{{ __('messages.ticket_status_new') }}" {{ $ticket->status === __('messages.ticket_status_new') ? 'selected' : '' }}>
                            {{ __('messages.ticket_status_new') }}
                        </option>
                        <option value="{{ __('messages.ticket_status_processing') }}" {{ $ticket->status === __('messages.ticket_status_processing') ? 'selected' : '' }}>
                            {{ __('messages.ticket_status_processing') }}
                        </option>
                        <option value="{{ __('messages.ticket_status_answered') }}" {{ $ticket->status === __('messages.ticket_status_answered') ? 'selected' : '' }}>
                            {{ __('messages.ticket_status_answered') }}
                        </option>
                        <option value="{{ __('messages.ticket_status_closed') }}" {{ $ticket->status === __('messages.ticket_status_closed') ? 'selected' : '' }}>
                            {{ __('messages.ticket_status_closed') }}
                        </option>
                    </select>
                </div>

                {{-- ✍️ الرد الجديد --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">✍️ أضف رد جديد:</label>
                    <textarea name="reply" rows="4" class="border rounded px-3 py-2 w-full" placeholder="اكتب ردك هنا..."></textarea>
                </div>

                {{-- 💾 زر الحفظ --}}
                <button type="submit"
                    class="bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600 font-semibold">
                    💾 حفظ التغييرات
                </button>
            </form>
        </div>

        {{-- 🔙 العودة --}}
        <div class="mt-6">
            <a href="{{ route('admin.support_tickets.index') }}"
               class="text-sm text-gray-600 hover:underline">⬅️ {{ __('messages.back_to_tickets') ?? 'العودة إلى قائمة التذاكر' }}</a>
        </div>
    </div>
</x-app-layout>
