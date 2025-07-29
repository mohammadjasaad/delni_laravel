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
        <div id="chatBox" class="h-64 overflow-y-auto border rounded p-4 bg-white mb-6 text-sm sm:text-base space-y-2">
            {{-- الرسائل ستُحمّل هنا --}}
        </div>

        {{-- ✅ نموذج إرسال رد السائق --}}
        <form id="chatForm" class="flex gap-2 items-center" method="POST" action="{{ route('driver.message.reply', ['order' => $order->id]) }}">
            @csrf
            <input type="hidden" name="sender" value="driver">
            <input type="text" name="message" placeholder="✍️ اكتب ردك..." required
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
        async function loadMessages() {
            const res = await fetch("{{ route('passenger.message.fetch', ['order_id' => $order->id]) }}");
            const messages = await res.json();
            const chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = "";
            messages.forEach(msg => {
                const msgDiv = document.createElement("div");
                msgDiv.className = msg.sender === 'driver' ? 'text-right' : 'text-left';
                msgDiv.innerHTML = `
                    <div class="inline-block px-3 py-2 rounded 
                        ${msg.sender === 'driver' ? 'bg-yellow-100 text-yellow-900' : 'bg-gray-100 text-gray-800'}">
                        <strong>${msg.sender === 'driver' ? '👨‍✈️ أنت' : '👤 الراكب'}:</strong> ${msg.message}
                    </div>`;
                chatBox.appendChild(msgDiv);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        document.getElementById("chatForm").addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            await fetch(this.action, {
                method: "POST",
                body: formData
            });
            this.reset();
            loadMessages();
        });

        setInterval(loadMessages, 5000);
        loadMessages();
    </script>
</x-app-layout>
