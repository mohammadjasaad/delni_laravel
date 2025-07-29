<x-app-layout>
    <div class="max-w-4xl mx-auto p-4 sm:p-6 md:p-10 mt-6 bg-white rounded-lg shadow-md">
        <h2 class="text-xl sm:text-2xl font-bold text-center text-yellow-600 mb-6">👨‍✈️ لوحة تحكم السائق</h2>

        {{-- ✅ رسالة النجاح --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center text-sm sm:text-base">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ معلومات السائق --}}
        <div class="text-gray-800 space-y-3 sm:space-y-4 text-sm sm:text-base">
            <div><strong>👤 الاسم:</strong> {{ $driver->name }}</div>
            <div><strong>🚗 رقم السيارة:</strong> {{ $driver->car_number }}</div>
            <div>
                <strong>📍 الحالة:</strong>
                <span class="font-semibold 
                    {{ $driver->status === 'متاح' ? 'text-green-600' : 
                       ($driver->status === 'مشغول' ? 'text-red-600' : 'text-gray-500') }}">
                    {{ $driver->status ?? 'غير معروف' }}
                </span>
            </div>
            <div>
                <strong>🌍 الموقع:</strong> {{ $driver->latitude ?? 'غير محدد' }}, {{ $driver->longitude ?? 'غير محدد' }}
            </div>
        </div>

        {{-- ✅ تغيير الحالة --}}
        <div class="mt-6">
            <form method="POST" action="{{ route('driver.status', $driver->id) }}" class="space-y-3">
                @csrf
                <label for="status" class="block font-semibold text-gray-700">🛠️ تغيير الحالة:</label>
                <select name="status" id="status"
                        class="w-full p-2 border border-gray-300 rounded text-sm sm:text-base">
                    <option value="متاح" {{ $driver->status === 'متاح' ? 'selected' : '' }}>✅ متاح</option>
                    <option value="مشغول" {{ $driver->status === 'مشغول' ? 'selected' : '' }}>🚕 مشغول</option>
                    <option value="غير متصل" {{ $driver->status === 'غير متصل' ? 'selected' : '' }}>❌ غير متصل</option>
                </select>
                <button type="submit"
                        class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded w-full sm:w-auto">
                    💾 حفظ التغيير
                </button>
            </form>
        </div>

        {{-- ✅ تحديث الموقع --}}
        <div class="mt-6">
            <form method="POST" action="{{ route('driver.location', $driver->id) }}">
                @csrf
                <input type="hidden" name="lat" id="lat">
                <input type="hidden" name="lon" id="lon">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded w-full">
                    🔄 تحديث موقعي الجغرافي الحالي
                </button>
            </form>
        </div>

{{-- ✅ الطلبات الجارية --}}
@if ($driver->taxiOrders && count($driver->taxiOrders) > 0)
    <div class="mt-10 bg-gray-100 p-4 rounded shadow text-sm sm:text-base">
        <h3 class="text-lg font-bold text-yellow-700 mb-4 text-center">📋 الطلبات الجارية</h3>

        @foreach ($driver->taxiOrders as $activeOrder)
            <div class="border border-gray-300 rounded p-4 mb-4 bg-white">
                <p><strong>👤 الراكب:</strong> {{ $activeOrder->user_name }}</p>
                <p><strong>🗺️ من:</strong> {{ $activeOrder->pickup_latitude }}, {{ $activeOrder->pickup_longitude }}</p>
                <p><strong>🔁 الحالة:</strong> {{ $activeOrder->status }}</p>

                <div class="mt-3 flex gap-2">
                    <a href="{{ route('driver.chat', $activeOrder->id) }}"
                       class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded">
                        💬 المحادثة مع الراكب
                    </a>
                    <a href="{{ route('trip.completed', ['order' => $activeOrder->id]) }}"
                       class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        ✅ إنهاء الرحلة
                    </a>
                </div>
            </div>
        @endforeach
    </div>
@endif

        {{-- ✅ الطلب الحالي --}}
        @if($order)
        <div class="mt-8 bg-gray-100 p-4 rounded shadow text-sm sm:text-base">
            <h3 class="text-lg font-bold text-yellow-700 mb-2 text-center">🚖 تفاصيل الطلب الحالي</h3>
            <p><strong>👤 الراكب:</strong> {{ $order->user_name }}</p>
            <p><strong>📍 نقطة الانطلاق:</strong> {{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}</p>
            <p><strong>🔁 الحالة:</strong> {{ $order->status }}</p>
            <div class="mt-4 flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('trip.completed') }}"
                   class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-center">
                    ✅ إنهاء الرحلة
                </a>
                <a href="{{ route('home') }}"
                   class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded text-center">
                    ❌ إلغاء الطلب
                </a>
            </div>
        </div>
        @endif

        {{-- ✅ المحادثة --}}
        @if($order)
        <div class="mt-8 bg-white border p-4 rounded shadow">
            <h3 class="text-lg font-bold mb-3">💬 المحادثة مع الراكب</h3>
            <div id="chatBox" class="h-64 overflow-y-auto border p-2 rounded mb-3 bg-gray-50 text-sm sm:text-base"></div>
            <form id="chatForm" class="flex flex-col sm:flex-row gap-2">
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="sender" value="driver">
                <input type="text" name="message" placeholder="اكتب رسالتك..." class="flex-1 border rounded px-3 py-2"
                       required>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">إرسال</button>
            </form>
        </div>
        @endif

        {{-- ✅ العودة --}}
        <div class="mt-6 text-center">
            <a href="{{ route('drivers.index') }}" class="text-sm text-gray-600 hover:underline">
                ⬅️ العودة إلى قائمة السائقين
            </a>
        </div>
    </div>

    {{-- ✅ JavaScript --}}
    <script>
        // تحديد الموقع
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                document.getElementById('lat').value = position.coords.latitude;
                document.getElementById('lon').value = position.coords.longitude;
            });
        }

        // تحميل الرسائل
        async function loadMessages() {
            const res = await fetch("{{ route('driver.message.fetch') }}");
            const messages = await res.json();
            const chatBox = document.getElementById("chatBox");
            chatBox.innerHTML = "";
            messages.forEach(msg => {
                const msgDiv = document.createElement("div");
                msgDiv.className = "mb-2";
                msgDiv.innerHTML = `<strong>${msg.sender === 'driver' ? '👨‍✈️ أنت' : '👤 الراكب'}:</strong> ${msg.message}`;
                chatBox.appendChild(msgDiv);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        document.getElementById("chatForm").addEventListener("submit", async function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            await fetch("{{ route('driver.message.store') }}", {
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
