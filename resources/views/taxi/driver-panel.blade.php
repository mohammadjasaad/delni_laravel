<x-main-layout title="لوحة سائق Delni Taxi">
    <div class="max-w-4xl mx-auto p-6 bg-white shadow rounded text-right space-y-6">

        {{-- ✅ العنوان --}}
        <h1 class="text-2xl font-bold text-yellow-600">👨‍✈️ مرحباً بك يا سائق!</h1>
        <p class="text-gray-700">هنا يمكنك متابعة المحادثات مع الركاب والتحكم بحالة الطلب.</p>

        {{-- ✅ حالة الاتصال --}}
        <div id="connectionStatus" class="text-sm font-semibold text-gray-600 text-center">
            🟡 جاري التحقق من الاتصال...
        </div>

        {{-- ✅ الرسائل --}}
        <div class="bg-gray-100 rounded p-4 shadow">
            <div class="flex justify-between items-center mb-2">
                <h2 class="text-lg font-semibold">📨 الرسائل الواردة <span id="messageCount" class="text-sm text-gray-500"></span></h2>
                <button onclick="loadDriverMessages()" class="text-sm text-blue-600 hover:underline">🔄 تحديث يدوي</button>
            </div>

            <div id="driverChatBox" class="h-72 overflow-y-auto bg-white p-3 rounded border text-sm space-y-3 text-right">
                <p class="text-center text-gray-400">جاري تحميل الرسائل...</p>
            </div>
        </div>

        {{-- ✅ نموذج إرسال رد --}}
        <form id="driverChatForm" class="flex gap-2" method="POST" action="{{ route('driver.message.store') }}">
            @csrf
            <input type="hidden" name="sender" value="driver">
            <input type="hidden" name="driver_name" value="أبو أحمد">
            <input type="text" name="message" id="driverMessage" placeholder="✍️ اكتب ردك هنا..." required class="flex-1 border px-3 py-2 rounded focus:outline-none focus:ring focus:border-yellow-400">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                إرسال
            </button>
        </form>

        {{-- ✅ أزرار الحالة --}}
        <div class="flex flex-col sm:flex-row justify-center gap-4 pt-6">
            <button onclick="notifyArrival()" class="bg-yellow-500 text-white px-6 py-2 rounded-full hover:bg-yellow-600 transition">
                🚗 تم الوصول
            </button>
            <a href="{{ route('trip.completed') }}" class="bg-green-600 text-white px-6 py-2 rounded-full hover:bg-green-700 transition text-center">
                ✅ إنهاء الرحلة
            </a>
        </div>
    </div>

    {{-- ✅ صوت تنبيه --}}
    <audio id="newMessageSound" src="/sounds/notify.mp3" preload="auto"></audio>

    <script>
        let lastMessageCount = 0;

        async function loadDriverMessages() {
            const status = document.getElementById("connectionStatus");
            try {
                const res = await fetch("{{ route('driver.message.fetch') }}");
                const messages = await res.json();
                const box = document.getElementById("driverChatBox");
                const counter = document.getElementById("messageCount");

                // ✅ صوت عند وصول رسالة جديدة
                if (messages.length > lastMessageCount) {
                    document.getElementById("newMessageSound").play();
                }

                lastMessageCount = messages.length;
                counter.textContent = `(${messages.length})`;

                box.innerHTML = "";
                messages.forEach(msg => {
                    const line = document.createElement("div");
                    const time = new Date(msg.created_at).toLocaleTimeString();
                    const isDriver = msg.sender === 'driver';

                    line.className = isDriver
                        ? 'bg-yellow-100 p-2 rounded shadow'
                        : 'bg-gray-200 p-2 rounded shadow';

                    line.innerHTML = `<strong>${isDriver ? '🧑‍✈️ أنت' : '👤 الراكب'}:</strong> ${msg.message}
                    <div class="text-xs text-gray-500 mt-1">${time}</div>`;
                    box.appendChild(line);
                });

                box.scrollTop = box.scrollHeight;
                status.textContent = "🟢 متصل بالسيرفر";
            } catch (err) {
                status.textContent = "🔴 غير متصل بالسيرفر";
            }
        }

        document.getElementById("driverChatForm").addEventListener("submit", async function(e) {
            e.preventDefault();
            const input = document.getElementById("driverMessage");
            if (input.value.trim() === "") return;
            const formData = new FormData(this);
            await fetch(this.action, {
                method: "POST",
                body: formData
            });
            this.reset();
            loadDriverMessages();
        });

        function notifyArrival() {
            alert("📣 تم إعلام الراكب بأنك وصلت! 🚗");
        }

        setInterval(loadDriverMessages, 5000);
        loadDriverMessages();
    </script>
</x-main-layout>
