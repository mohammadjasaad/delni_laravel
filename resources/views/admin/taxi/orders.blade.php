{{-- resources/views/admin/taxi/orders.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">

        @php
            $statusIcons = [
                'pending'   => '⏳',
                'accepted'  => '📌',
                'ongoing'   => '🚦',
                'completed' => '✅',
                'cancelled' => '❌',
            ];

            $statusClasses = [
                'pending'   => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                'accepted'  => 'bg-blue-100 text-blue-800 border border-blue-300',
                'ongoing'   => 'bg-purple-100 text-purple-800 border border-purple-300',
                'completed' => 'bg-green-100 text-green-800 border border-green-300',
                'cancelled' => 'bg-red-100 text-red-800 border border-red-300',
            ];
        @endphp

        {{-- 🚖 قائمة الطلبات --}}
        <div class="p-4 border rounded bg-white shadow mb-6">
            <h2 class="text-xl font-bold mb-4 flex justify-between items-center">
                🚖 قائمة الطلبات
                <a href="{{ route('admin.taxi.orders') }}" class="text-sm text-gray-500 hover:underline">🔄 إعادة تعيين</a>
            </h2>

            {{-- 🔍 الفلترة --}}
            <form method="GET" action="{{ route('admin.taxi.orders') }}" class="flex flex-wrap gap-3 mb-4 items-center">
                <input type="text" name="driver" value="{{ request('driver') }}" placeholder="🚖 السائق"
                    class="border rounded h-10 px-3 w-40">
                
                <input type="text" name="user_id" value="{{ request('user_id') }}" placeholder="👤 رقم المستخدم"
                    class="border rounded h-10 px-3 w-40">
                
                <select name="status" class="border rounded h-10 px-3 w-40">
                    <option value="">📋 كل الحالات</option>
                    @foreach($statusIcons as $key => $icon)
                        <option value="{{ $key }}" {{ request('status') == $key ? 'selected' : '' }}>
                            {{ $icon }} {{ __("messages.$key") }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="h-10 px-4 bg-yellow-500 text-white rounded shadow hover:bg-yellow-600 flex items-center gap-1">
                    🔍 بحث
                </button>
            </form>

            @if($orders->isEmpty())
                <div class="p-4 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded">
                    🚫 لا توجد طلبات مطابقة لخيارات البحث الحالية
                </div>
            @endif

            {{-- 🔁 عرض الطلبات كبطاقات --}}
            @foreach($orders as $order)
<div class="order-card {{ $order->status }} mb-6 p-4 border rounded-xl shadow relative">
    {{-- 🟡 أيقونة الحالة --}}
    <div class="status-icon">
        {{ $statusIcons[$order->status] ?? '❔' }}
    </div>
                    {{-- العنوان + الحالة --}}
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="font-bold text-lg">🚖 طلب #{{ $order->id }}</h3>
                        <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                            {{ $statusIcons[$order->status] ?? '' }}
                            {{ __("messages.".$order->status) ?? $order->status }}
                        </span>
                    </div>

                    {{-- تفاصيل المستخدم والسائق --}}
                    <p>👤 المستخدم: <strong>{{ $order->user_id }}</strong></p>
                    <p>🚖 السائق: <strong>{{ $order->driver->name ?? 'غير محدد' }}</strong></p>
                    <p>📍 من: {{ $order->pickup_latitude }}, {{ $order->pickup_longitude }}</p>
                    <p>📍 إلى: {{ $order->dropoff_latitude }}, {{ $order->dropoff_longitude }}</p>

                    {{-- ⭐ التقييم كنجمات --}}
                    <p>
                        ⭐ التقييم:
                        @if($order->rating)
                            @for($i=1; $i<=5; $i++)
                                <span class="{{ $i <= $order->rating ? 'text-yellow-500' : 'text-gray-300' }}">★</span>
                            @endfor
                        @else
                            —
                        @endif
                    </p>

                    {{-- 🔘 تحديث الحالة --}}
                    <form action="{{ route('taxi.order.status', $order->id) }}" method="POST" class="mt-2">
                        @csrf
                        @method('PUT')
                        <select name="status" onchange="this.form.submit()" class="text-sm border rounded p-1">
                            @foreach($statusIcons as $key => $icon)
                                <option value="{{ $key }}" {{ $order->status == $key ? 'selected' : '' }}>
                                    {{ $icon }} {{ __("messages.$key") }}
                                </option>
                            @endforeach
                        </select>
                    </form>

                    {{-- 📩 الرسائل الخاصة بالطلب --}}
                    @if($order->messages->count())
                        <div class="mt-3 p-3 border rounded bg-gray-50">
                            <p class="font-semibold mb-2">📩 رسائل الطلب:</p>
                            @foreach($order->messages as $msg)
                                <div class="mb-2 text-sm">
                                    <span class="font-bold">
                                        @if($msg->sender_type == 'user') 👤 المستخدم
                                        @elseif($msg->sender_type == 'driver') 🚖 السائق
                                        @elseif($msg->sender_type == 'admin') 🛠️ الأدمن
                                        @endif
                                    </span>:
                                    {{ $msg->message }}
                                    <span class="text-xs text-gray-500">⏰ {{ $msg->created_at->format('H:i') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @endforeach

            {{-- روابط الصفحات --}}
            <div class="mt-4">
                {{ $orders->links() }}
            </div>
        </div>

        {{-- 💬 جميع الرسائل --}}
        <div class="p-4 border rounded bg-white shadow">
            <h2 class="text-xl font-bold mb-4">💬 جميع الرسائل</h2>
            <div class="space-y-3">
                @foreach($messages as $msg)
                    <div class="flex {{ $msg->sender_type == 'user' ? 'justify-end' : ($msg->sender_type == 'admin' ? 'justify-center' : 'justify-start') }}">
                        <div class="relative max-w-xs px-3 py-2 rounded-lg shadow text-sm
                            @class([
                                'bg-blue-100 text-blue-900 text-right bubble-user'   => $msg->sender_type == 'user',
                                'bg-purple-100 text-purple-900 text-center bubble-admin' => $msg->sender_type == 'admin',
                                'bg-green-100 text-green-900 text-left bubble-driver' => $msg->sender_type == 'driver',
                            ])">

                            <p @class([
                                'font-semibold mb-1 text-xs',
                                'text-blue-700' => $msg->sender_type == 'user',
                                'text-green-700' => $msg->sender_type == 'driver',
                                'text-purple-700' => $msg->sender_type == 'admin',
                            ])>
                                @if($msg->sender_type == 'user') 👤 المستخدم
                                @elseif($msg->sender_type == 'driver') 🚖 السائق
                                @elseif($msg->sender_type == 'admin') 🛠️ الأدمن
                                @endif
                            </p>

                            <p>{{ $msg->message }}</p>

                            <div class="flex justify-between items-center mt-1 text-xs text-gray-500">
                                <span>⏰ {{ $msg->created_at->format('H:i') }}</span>
                                <span class="px-2 py-0.5 rounded {{ $statusClasses[$msg->order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusIcons[$msg->order->status] ?? '' }}
                                    {{ __("messages.".$msg->order->status) ?? $msg->order->status }}
                                </span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
