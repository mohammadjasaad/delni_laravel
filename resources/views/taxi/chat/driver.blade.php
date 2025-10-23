<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow-md">
        <h2 class="text-2xl font-bold text-yellow-600 text-center mb-6">👨‍✈️ المحادثة مع الراكب</h2>

        {{-- ✅ معلومات الطلب --}}
        <div class="bg-gray-100 p-4 rounded mb-6 text-sm sm:text-base">
            <p><strong>🚕 رقم الطلب:</strong> {{ $order->id }}</p>
            <p><strong>👤 الراكب:</strong> {{ $order->user->name ?? 'غير معروف' }}</p>
            <p><strong>📍 موقع الالتقاء:</strong> {{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}</p>
            <p><strong>📍 الوجهة:</strong> {{ $order->drop_latitude ?? 'غير متوفر' }}, {{ $order->drop_longitude ?? 'غير متوفر' }}</p>
            <p><strong>🔁 الحالة:</strong> {{ $order->status }}</p>
        </div>

        {{-- ✅ صندوق الرسائل --}}
        <div id="chatBox" class="h-72 overflow-y-auto border rounded p-4 bg-gray-50 mb-6 text-sm sm:text-base space-y-2">
            {{-- سيتم تحميل الرسائل هنا --}}
        </div>

        {{-- ✅ نموذج الإرسال --}}
        <form id="chatForm" class="flex gap-2 items-center">
            @csrf
            <input type="text" id="chatInput" name="message" placeholder="✍️ اكتب رسالتك..." required
                   class="flex-1 px-4 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-yellow-400">
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                إرسال
            </button>
        </form>

        {{-- ✅ زر العودة --}}
        <div class="mt-6 text-center">
            <a href="{{ route('driver.panel') }}" class="text-gray-600 hover:underline text-sm">
                ⬅️ العودة إلى لوحة تحكم السائق
            </a>
        </div>
    </div>

    {{-- ✅ JavaScript --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const orderId = {{ $order->id }};
            const chatBox = document.getElementById('chatBox');
            const input = document.getElementById('chatInput');
            const form = document.getElementById('chatForm');

            // ✅ تحميل الرسائل السابقة
            async function loadMessages() {
                const res = await fetch(`/api/taxi/messages/${orderId}`);
                const messages = await res.json();
                chatBox.innerHTML = '';
                messages.forEach(msg => appendMessage(msg.sender_type, msg.message));
            }

            // ✅ عرض الرسالة
            function appendMessage(sender, message) {
                const div = document.createElement('div');
                div.className = sender === 'driver'
                    ? 'text-right'
                    : 'text-left';
                div.innerHTML = `
                    <div class="inline-block px-3 py-2 rounded ${
                        sender === 'driver'
                            ? 'bg-yellow-100 text-yellow-900'
                            : 'bg-gray-200 text-gray-800'
                    }">
                        <strong>${sender === 'driver' ? '👨‍✈️ أنت' : '👤 الراكب'}:</strong> ${message}
                    </div>`;
                chatBox.appendChild(div);
                chatBox.scrollTop = chatBox.scrollHeight;
            }

            // ✅ استقبال الرسائل الفورية عبر Laravel Echo (Pusher)
            window.Echo.channel(`taxi-chat.${orderId}`)
                .listen('.TaxiMessageSent', (e) => {
                    appendMessage(e.message.sender_type, e.message.message);
                });

            // ✅ إرسال رسالة جديدة
            form.addEventListener('submit', async (e) => {
                e.preventDefault();
                const message = input.value.trim();
                if (!message) return;

                await fetch(`/api/taxi/messages`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        order_id: orderId,
                        sender_type: 'driver',
                        message: message
                    })
                });

                appendMessage('driver', message);
                input.value = '';
            });

            loadMessages();
        });
    </script>
</x-app-layout>
