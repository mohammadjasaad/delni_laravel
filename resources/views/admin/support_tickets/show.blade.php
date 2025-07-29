<x-app-layout>
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

            {{-- ✅ عرض الرد إن وُجد --}}
            @if($ticket->reply)
                <div><strong>✉️ الرد:</strong>
                    <div class="bg-green-50 border border-green-300 p-4 rounded mt-2 text-green-800 whitespace-pre-wrap">
                        {{ $ticket->reply }}
                    </div>
                </div>
            @endif

            <div><strong>📅 تم الإرسال في:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}</div>

            {{-- ✅ نموذج تحديث الحالة والرد --}}
            <form method="POST" action="{{ route('admin.support_tickets.update', $ticket->id) }}" class="mt-6">
                @csrf
                @method('PUT')

                {{-- 🔁 تحديث الحالة --}}
                <label class="block text-sm font-medium text-gray-700 mb-2">🔁 تحديث الحالة:</label>
                <select name="status" class="border rounded px-3 py-2 w-full max-w-sm mb-4">
                    <option value="جديد" {{ $ticket->status === 'جديد' ? 'selected' : '' }}>جديد</option>
                    <option value="قيد المعالجة" {{ $ticket->status === 'قيد المعالجة' ? 'selected' : '' }}>قيد المعالجة</option>
                    <option value="تم الرد" {{ $ticket->status === 'تم الرد' ? 'selected' : '' }}>تم الرد</option>
                    <option value="مغلق" {{ $ticket->status === 'مغلق' ? 'selected' : '' }}>مغلق</option>
                </select>

                {{-- 💬 الرد على التذكرة --}}
                <label class="block text-sm font-medium text-gray-700 mb-2">💬 الرد على التذكرة:</label>
                <textarea name="reply" rows="5" class="border rounded px-3 py-2 w-full">{{ old('reply', $ticket->reply) }}</textarea>

                {{-- 💾 زر الحفظ --}}
                <button type="submit"
                    class="mt-4 bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600 font-semibold">
                    💾 حفظ التغييرات
                </button>
            </form>
        </div>

        {{-- 🔙 العودة --}}
        <div class="mt-6">
            <a href="{{ route('admin.support_tickets.index') }}"
               class="text-sm text-gray-600 hover:underline">⬅️ العودة إلى قائمة التذاكر</a>
        </div>
    </div>
</x-app-layout>
