<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold text-yellow-600 text-center mb-6">💬 المحادثة مع الراكب</h2>

        {{-- ✅ معلومات الطلب --}}
        <div class="bg-gray-50 border p-4 rounded mb-6 text-sm sm:text-base">
            <p><strong>👨‍✈️ السائق:</strong> {{ $order->driver->name ?? 'غير معروف' }}</p>
            <p><strong>👤 الراكب:</strong> {{ $order->user_name }}</p>
            <p><strong>📍 من:</strong> {{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}</p>
            <p><strong>🔁 الحالة:</strong> {{ $order->status }}</p>
        </div>

        {{-- ✅ صندوق الرسائل --}}
        <div id="chatBox" class="h-64 overflow-y-auto border p-3 rounded bg-white mb-4 text-sm sm:text-base"></div>

        {{-- ✅ نموذج إرسال رسالة --}}
        <form id="chatForm" class="flex gap-2" method="POST" action="{{ route('driver.message.store') }}">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="sender" value="driver">
            <input type="text" name="message" placeholder="اكتب رسالتك..." required
                   class="flex-1 border rounded px-3 py-2">
            <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">إرسال</button>
        </form>

        {{-- ✅ زر العودة --}}
        <div class="mt-6 text-center">
            <a href="{{ route('drivers.panel', ['id' => $order->driver_id]) }}" class="text-gray-600 hover:underline">
                ⬅️ العودة إلى لوحة التحكم
            </a>
        </div>
    </div>

    {{-- ✅ JavaScript لتحميل الرسائل --}}
    <script>
        async function loadMessages() {
            const res = await fetch("{{ route('driver.message.fetch', ['order_id' => $order->id]) }}");
            const messages = await res.json();
            const chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = "";
            messages.forEach(msg => {
                const msgDiv = document.createElement("div");
                msgDiv.className = `mb-2 ${msg.sender === 'driver' ? 'text-right' : 'text-left'}`;
                msgDiv.innerHTML = `
                    <div class="inline-block px-3 py-2 rounded 
                        ${msg.sender === 'driver' ? 'bg-yellow-100 text-blue-800' : 'bg-gray-100 text-gray-800'}">
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
