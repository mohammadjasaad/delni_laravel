<x-main-layout title="💬 محادثات السائق">

    <div class="max-w-4xl mx-auto mt-10 bg-white p-6 rounded-lg shadow text-right">

        <h2 class="text-2xl font-bold mb-6 text-yellow-600">💬 المحادثة مع الراكب</h2>

        {{-- ✅ بيانات الطلب --}}
        <div class="mb-4 text-gray-800 text-sm">
            <p><strong>رقم الطلب:</strong> {{ $order->id }}</p>
            <p><strong>اسم الراكب:</strong> {{ $order->user_name ?? 'غير متوفر' }}</p>
        </div>

        {{-- 💬 المحادثة --}}
        <div class="bg-gray-50 border p-4 rounded h-64 overflow-y-auto mb-4" id="chatBox">
            @foreach ($messages as $message)
                <div class="mb-2 text-sm">
                    <strong>{{ $message->sender_type === 'driver' ? '🚕 أنت' : '👤 الراكب' }}:</strong>
                    {{ $message->message }}
                </div>
            @endforeach
        </div>

        {{-- 📩 نموذج إرسال رسالة --}}
        <form method="POST" action="{{ route('driver.message.reply', $order->id) }}" class="flex gap-2">
            @csrf
            <input type="hidden" name="sender_type" value="driver">
            <input type="text" name="message" placeholder="اكتب رسالتك..." class="flex-1 border rounded px-3 py-2" required>
            <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">إرسال</button>
        </form>

    </div>

</x-main-layout>
