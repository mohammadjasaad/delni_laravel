{{-- resources/views/taxi/order-status.blade.php --}}
<x-main-layout title="🚖 حالة طلب Delni Taxi">

    {{-- ✅ رسالة نجاح --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center max-w-xl mx-auto">
            {{ session('success') }}
        </div>
    @endif

    {{-- 🕓 تنبيه في حال عدم تعيين سائق --}}
    @if(!$driver)
        <div class="bg-yellow-100 text-yellow-800 p-4 rounded-lg text-center max-w-xl mx-auto mt-4">
            🚗 لم يتم تعيين سائق بعد — نعمل على إيجاد أقرب سائق لك ⏳
        </div>
    @endif

    {{-- 🚕 تفاصيل الطلب --}}
    <div class="max-w-2xl mx-auto px-4 py-10 text-center">
        <h1 class="text-3xl font-bold text-yellow-600 mb-4">🚖 حالة طلبك</h1>
        <p class="text-gray-700 mb-6 text-lg" id="order-status-text">🕓 جاري تحميل حالة الطلب...</p>

        {{-- 🗺️ موقع الراكب --}}
        <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">🗺️ موقع الراكب (نقطة الانطلاق)</h3>
        <div id="pickup-map" class="w-full h-[300px] rounded shadow border mb-6"></div>

        {{-- 🧭 تتبع السائق --}}
        <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">🚘 موقع السائق في الوقت الحقيقي</h3>
        <div id="driver-map" class="w-full h-[350px] rounded shadow border mb-6"></div>

        {{-- 👨‍✈️ تفاصيل السائق --}}
        <div id="driver-info" class="bg-white shadow-md rounded-lg p-6 mb-6 hidden">
            <h3 class="text-xl font-semibold text-yellow-600 mb-4 flex items-center gap-2">👨‍✈️ تفاصيل السائق</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 text-right">
                <div><span class="font-bold">👨‍✈️ الاسم:</span> <span id="driver-name"></span></div>
                <div><span class="font-bold">🚗 السيارة:</span> <span id="driver-car"></span></div>
                <div><span class="font-bold">📱 رقم الهاتف:</span> <span id="driver-phone"></span></div>
                <div><span class="font-bold">⏱️ الوصول المتوقع:</span>
                    <span id="eta" class="text-blue-600 font-semibold">جارٍ الحساب...</span>
                </div>
            </div>
        </div>

        {{-- 📞 زر التواصل --}}
        <div id="contact-btn" class="mb-4 hidden">
            <a href="#" id="driver-phone-link"
                class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition inline-block">
                📞 تواصل مع السائق
            </a>
        </div>

        {{-- 💬 المحادثة الفورية --}}
        <div class="max-w-2xl mx-auto mt-10 mb-16">
            <h3 class="text-xl font-bold text-gray-700 mb-4">💬 المحادثة مع السائق</h3>
            <div id="chat-box" class="border rounded-lg p-4 bg-gray-50 h-64 overflow-y-auto mb-4 text-right"></div>

            <form id="chat-form" class="flex gap-2">
                <input type="text" id="chat-message" class="flex-1 border rounded-lg p-2" placeholder="اكتب رسالتك..." required>
                <button type="submit" class="bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600">إرسال</button>
            </form>
        </div>

        {{-- 🔘 أزرار التحكم --}}
        <div class="text-center mt-8 space-y-4">
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-6">
                <button onclick="cancelOrder()"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">
                    ❌ إلغاء الطلب
                </button>
                <form id="complete-form" action="{{ route('taxi.order.complete.with.rating') }}" method="POST"
                    class="hidden" onsubmit="return confirm('هل أنت متأكد من إنهاء الرحلة وتقييم السائق؟')">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="driver_id" id="driver_id" value="">
                    <input type="hidden" name="driver_name" id="driver_name" value="">
                    <input type="hidden" name="rating" value="5">
                    <input type="hidden" name="comment" value="رحلة ممتازة">
                    <button type="submit"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">
                        ✅ إنهاء الرحلة
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- 🗺️ سكريبت الخريطة والتتبع --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const pickupLat = {{ $order->pickup_latitude }};
            const pickupLng = {{ $order->pickup_longitude }};
            const orderId = {{ $order->id }};
            const API_KEY = "5b3ce3597851110001cf6248";

            const pickupMap = L.map('pickup-map').setView([pickupLat, pickupLng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(pickupMap);
            L.marker([pickupLat, pickupLng]).addTo(pickupMap).bindPopup("📍 موقع الراكب");

            const driverMap = L.map('driver-map').setView([pickupLat, pickupLng], 14);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(driverMap);

            let driverMarker = null, routeLine = null;

            async function updateDriverLocation() {
                const res = await fetch(`/api/taxi/order-status/${orderId}`);
                const data = await res.json();
                if (!data.driver) return;

                const lat = parseFloat(data.driver.latitude);
                const lng = parseFloat(data.driver.longitude);

                if (!driverMarker) {
                    driverMarker = L.marker([lat, lng], { icon: L.icon({
                        iconUrl: 'https://cdn-icons-png.flaticon.com/512/3097/3097144.png', iconSize: [40, 40],
                    })}).addTo(driverMap);
                } else driverMarker.setLatLng([lat, lng]);

                const routeUrl = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${API_KEY}&start=${lng},${lat}&end=${pickupLng},${pickupLat}`;
                const routeData = await (await fetch(routeUrl)).json();
                const coords = routeData.features[0].geometry.coordinates.map(c => [c[1], c[0]]);
                const summary = routeData.features[0].properties.summary;
                const distanceKm = summary.distance / 1000;
                const durationMin = summary.duration / 60;

                if (routeLine) driverMap.removeLayer(routeLine);
                routeLine = L.polyline(coords, { color: '#2563eb', weight: 5 }).addTo(driverMap);
                document.getElementById("eta").innerText = `${distanceKm.toFixed(2)} كم — ${Math.ceil(durationMin)} دقيقة`;
            }

            setInterval(updateDriverLocation, 5000);
            updateDriverLocation();
        });
    </script>

    {{-- 💬 سكريبت المحادثة --}}
    <script src="https://js.pusher.com/8.2/pusher.min.js"></script>
    <script src="/js/echo.js"></script>
    <script>
        const orderId = {{ $order->id }};
        const chatBox = document.getElementById('chat-box');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-message');

        function appendMessage(msg, self = false) {
            const div = document.createElement('div');
            div.className = 'p-2 mb-1 rounded-lg ' + (self ? 'bg-yellow-300 ml-auto text-right' : 'bg-gray-200 mr-auto text-left');
            div.textContent = msg.message;
            chatBox.appendChild(div);
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        async function loadMessages() {
            const res = await fetch(`/taxi/order/${orderId}/messages`);
            const messages = await res.json();
            chatBox.innerHTML = '';
            messages.forEach(m => appendMessage(m, m.sender_type === 'user'));
        }

        chatForm.addEventListener('submit', async e => {
            e.preventDefault();
            const text = chatInput.value.trim();
            if (!text) return;

            appendMessage({ message: text }, true);
            chatInput.value = '';

            await fetch(`/taxi/order/${orderId}/messages`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: JSON.stringify({ order_id: orderId, message: text })
            });
        });

        window.Echo.channel(`taxi-chat-${orderId}`)
            .listen('TaxiMessageSent', e => appendMessage(e.message, e.message.sender_type === 'user'));

        loadMessages();

        function cancelOrder() {
            if (confirm('هل أنت متأكد من إلغاء الطلب؟')) {
                fetch(`/api/taxi/order-cancel/${orderId}`, { method: 'POST' })
                    .then(() => location.reload());
            }
        }
    </script>
{{-- 💬 نافذة المحادثة الفورية --}}
<div id="chat-box" class="fixed bottom-4 right-4 w-96 bg-white shadow-xl rounded-xl border border-gray-200 z-50">
    <div class="bg-yellow-500 text-white p-3 rounded-t-xl font-semibold flex justify-between items-center">
        <span>💬 المحادثة مع السائق</span>
        <button id="toggle-chat" class="text-sm bg-yellow-600 hover:bg-yellow-700 px-2 py-1 rounded">إخفاء</button>
    </div>

    <div id="chat-messages" class="h-64 overflow-y-auto p-3 space-y-2 text-sm bg-gray-50 text-right"></div>

    <form id="chat-form" class="flex border-t">
        <input type="text" id="chat-input" class="flex-1 p-2 focus:outline-none" placeholder="اكتب رسالتك...">
        <button class="bg-yellow-500 text-white px-4 hover:bg-yellow-600 transition">إرسال</button>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const orderId = {{ $order->id }};
    const senderType = '{{ Auth::check() ? 'user' : 'driver' }}';
    const chatBox = document.getElementById('chat-box');
    const toggleChatBtn = document.getElementById('toggle-chat');

    // ✅ إخفاء/إظهار الدردشة
    toggleChatBtn.addEventListener('click', () => {
        if (chatBox.classList.contains('collapsed')) {
            document.getElementById('chat-messages').style.display = 'block';
            document.getElementById('chat-form').style.display = 'flex';
            toggleChatBtn.innerText = 'إخفاء';
            chatBox.classList.remove('collapsed');
        } else {
            document.getElementById('chat-messages').style.display = 'none';
            document.getElementById('chat-form').style.display = 'none';
            toggleChatBtn.innerText = 'إظهار';
            chatBox.classList.add('collapsed');
        }
    });

    // ✅ تحميل الرسائل السابقة
    fetch(`/api/taxi/messages/${orderId}`)
        .then(res => res.json())
        .then(messages => messages.forEach(msg => appendMessage(msg.sender_type, msg.message)));

    // ✅ استقبال الرسائل الجديدة من Pusher عبر Laravel Echo
    window.Echo.channel(`taxi-chat.${orderId}`)
        .listen('.TaxiMessageSent', (e) => {
            appendMessage(e.message.sender_type, e.message.message);
        });

    // ✅ إرسال رسالة جديدة
    document.getElementById('chat-form').addEventListener('submit', async (e) => {
        e.preventDefault();
        const input = document.getElementById('chat-input');
        const text = input.value.trim();
        if (!text) return;

        await fetch(`/api/taxi/messages`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                order_id: orderId,
                sender_type: senderType,
                message: text
            })
        });

        appendMessage(senderType, text);
        input.value = '';
    });

    // ✅ عرض الرسائل في الصندوق
    function appendMessage(sender, text) {
        const box = document.getElementById('chat-messages');
        const msg = document.createElement('div');
        msg.className =
            sender === 'user'
                ? 'bg-yellow-100 text-gray-800 p-2 rounded-lg ml-10 text-right'
                : 'bg-gray-200 text-gray-700 p-2 rounded-lg mr-10 text-left';
        msg.innerText = text;
        box.appendChild(msg);
        box.scrollTop = box.scrollHeight;
    }
});
</script>

</x-main-layout>
