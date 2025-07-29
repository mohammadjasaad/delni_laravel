<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">📄 تفاصيل التذكرة #{{ $ticket->id }}</h1>

        {{-- ✅ محتوى التذكرة --}}
        <div class="bg-white shadow rounded-lg p-6 space-y-4 text-gray-700">

            <div>
                <strong>📝 الموضوع:</strong> {{ $ticket->subject }}
            </div>

            <div>
                <strong>💬 رسالتك:</strong>
                <div class="bg-gray-100 p-4 rounded mt-2 whitespace-pre-wrap">{{ $ticket->message }}</div>
            </div>

            <div>
                <strong>📅 تم الإرسال في:</strong> {{ $ticket->created_at->format('Y-m-d H:i') }}
            </div>

            <div>
                <strong>📌 الحالة:</strong>
                <span class="px-2 py-1 rounded text-white text-sm font-bold
                    {{ $ticket->status === 'جديد' ? 'bg-blue-500' : 
                       ($ticket->status === 'قيد المعالجة' ? 'bg-yellow-500' : 
                       ($ticket->status === 'تم الرد' ? 'bg-green-600' : 'bg-gray-500')) }}">
                    {{ $ticket->status }}
                </span>
            </div>

            {{-- ✅ الرد من الإدارة --}}
            @if($ticket->reply)
                <div>
                    <strong>✉️ رد الإدارة:</strong>
                    <div class="bg-yellow-100 p-4 rounded mt-2 whitespace-pre-wrap text-gray-800">{{ $ticket->reply }}</div>
                </div>
            @endif
        </div>

        {{-- 🔙 زر العودة --}}
        <div class="mt-6">
            <a href="{{ route('support.index') }}" class="text-sm text-gray-600 hover:underline">⬅️ العودة إلى التذاكر</a>
        </div>

    </div>
</x-app-layout>
