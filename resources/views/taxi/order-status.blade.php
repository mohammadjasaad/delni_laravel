<x-main-layout title="🚖 حالة طلب Delni Taxi">
    {{-- 🔔 بانر حالة الإشعارات --}}
    <div id="notifBanner" class="w-full text-center py-2 font-semibold text-white hidden"></div>

    {{-- 🚦 شريط الحالة --}}
    <div id="statusBar" class="w-full text-center py-3 font-bold text-white transition-colors duration-500">
        🚦 جاري تحميل الحالة...
    </div>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center max-w-xl mx-auto">
            {{ session('success') }}
        </div>
    @endif

    {{-- ⭐ تقييم السائق --}}
    <div class="bg-white p-6 rounded shadow max-w-xl mx-auto mt-8">
        <h2 class="text-xl font-bold text-gray-800 text-center mb-4">⭐ قيّم السائق</h2>
        <form method="POST" action="{{ route('submit.rating') }}">
            @csrf
            <input type="hidden" name="driver_name" value="{{ $driver->name }}">
            <div class="mb-4 text-right">
                <label for="rating" class="block text-gray-700 font-semibold mb-1">التقييم:</label>
                <select name="rating" id="rating" class="w-full border rounded px-3 py-2">
                    <option value="">اختر التقييم</option>
                    <option value="5">⭐⭐⭐⭐⭐ ممتاز</option>
                    <option value="4">⭐⭐⭐⭐ جيد جدًا</option>
                    <option value="3">⭐⭐⭐ جيد</option>
                    <option value="2">⭐⭐ مقبول</option>
                    <option value="1">⭐ ضعيف</option>
                </select>
            </div>
            <div class="mb-4 text-right">
                <label for="comment" class="block text-gray-700 font-semibold mb-1">ملاحظات:</label>
                <textarea name="comment" id="comment" rows="3" class="w-full border rounded px-3 py-2"></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-yellow-500 text-white px-5 py-2 rounded hover:bg-yellow-600 transition">
                    إرسال التقييم
                </button>
            </div>
        </form>
    </div>

    {{-- 🚕 تفاصيل الطلب --}}
    <div class="max-w-2xl mx-auto px-4 py-10 text-center">
        <h1 class="text-3xl font-bold text-yellow-600 mb-2">🚖 طلبك قيد التنفيذ</h1>
        <div class="text-sm text-gray-500 mb-4">آخر تحديث: <span id="lastUpdate">الآن</span></div>

        <p class="text-gray-700 mb-6" id="statusText">
            @if ($order->status === 'قيد التنفيذ')
                تم إرسال طلبك! السائق الأقرب في طريقه إليك.
            @elseif ($order->status === 'بدأت الرحلة')
                🚖 الرحلة بدأت! استمتع بمشوارك.
            @elseif ($order->status === 'منتهي')
                ✅ الرحلة منتهية.
            @else
                🚧 حالة الطلب: {{ $order->status }}
            @endif
        </p>

        {{-- 🗺️ خريطة موقع الراكب فقط --}}
        <h3 class="text-xl font-bold text-gray-700 mt-10 mb-2">🗺️ موقع الراكب (نقطة الانطلاق)</h3>
        <div id="pickup-map" class="w-full h-[300px] rounded shadow border mb-6"></div>

        {{-- 👨‍✈️ تفاصيل السائق --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <h3 class="text-xl font-semibold text-yellow-600 mb-4 flex items-center gap-2">👨‍✈️ تفاصيل السائق</h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 text-right">
                <div><span class="font-bold">👨‍✈️ الاسم:</span> <span id="dName">{{ $driver->name }}</span></div>
                <div><span class="font-bold">🚗 السيارة:</span> <span id="dCar">{{ $driver->car_number }}</span></div>
                <div>
                    <span class="font-bold">📱 رقم الهاتف:</span>
                    <a id="dPhone" href="tel:{{ $driver->phone ?? '' }}">{{ $driver->phone ?? 'غير متوفر' }}</a>
                </div>
                <div><span class="font-bold">⏱️ الوصول المتوقع:</span> <span id="eta" class="text-blue-600 font-semibold">جارٍ الحساب...</span></div>
                <div><span class="font-bold">🚦 الحالة:</span> <span id="dStatus">{{ $driver->status }}</span></div>
            </div>

            {{-- 🔔 تفعيل/تعطيل إشعارات المتصفح --}}
            <div class="mt-4 text-right">
                <label class="inline-flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" id="notifToggle" class="h-4 w-4">
                    <span class="text-sm text-gray-700">تفعيل إشعارات المتصفح لهذه الرحلة</span>
                </label>
                <div class="text-xs text-gray-500 mt-1">
                    ستصلك إشعارات عند وصول السائق أو تغيّر الحالة.
                </div>
            </div>
        </div>

        {{-- 📞 زر الاتصال --}}
        <div class="mb-4">
            <button id="contactDriverBtn" class="bg-blue-500 text-white px-6 py-2 rounded-full hover:bg-blue-600 transition">
                📞 تواصل مع السائق
            </button>
        </div>

        {{-- 🗺️ الخريطة الكبيرة --}}
        <div id="map" class="w-full h-[500px] rounded-lg shadow mb-6"></div>

        {{-- 💬 المحادثة --}}
        <div class="max-w-xl mx-auto bg-white shadow rounded-lg p-5 mt-10">
            <h2 class="text-xl font-bold text-yellow-600 mb-4 text-center">💬 المحادثة مع السائق</h2>
            <div id="chatBox" class="h-64 overflow-y-auto border border-gray-300 p-4 rounded-lg bg-gray-50 space-y-2 text-sm text-right"></div>
            <form id="chatForm" class="mt-4 flex gap-3">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="sender" value="user">
                <input type="text" name="message" placeholder="✍️ اكتب رسالتك هنا..." class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500" required>
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg transition">إرسال</button>
            </form>
        </div>

        {{-- 🔘 أزرار التحكم --}}
        <div class="text-center mt-8 space-y-4">
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4 mt-6">
                @if ($order->status === 'قيد التنفيذ')
                    <form action="{{ route('taxi.order.start', $order->id) }}" method="POST" onsubmit="return confirm('هل أنت متأكد أنك تريد بدء الرحلة؟')">
                        @csrf
                        <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">🚦 بدأ الرحلة</button>
                    </form>
                @endif
                <button onclick="cancelOrder()" class="bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">❌ إلغاء الطلب</button>
                <form action="{{ route('taxi.complete.with.rating') }}" method="POST" onsubmit="return confirm('هل أنت متأكد من إنهاء الرحلة وتقييم السائق؟')">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <input type="hidden" name="driver_id" value="{{ $driver->id }}">
                    <input type="hidden" name="driver_name" value="{{ $driver->name }}">
                    <input type="hidden" name="rating" value="5">
                    <input type="hidden" name="comment" value="رحلة ممتازة">
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow transition-all duration-200">✅ إنهاء الرحلة</button>
                </form>
            </div>
        </div>

        {{-- ✅ سكربت واحد منظم (Echo + Refresh + Chat) --}}
        @include('partials.taxi-live-js', ['order' => $order, 'driver' => $driver])
    </div>
</x-main-layout>
