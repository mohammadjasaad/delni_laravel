{{-- resources/views/admin/taxi/orders.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto p-6">
        <h1 class="text-2xl font-bold mb-6">🚖 جميع طلبات التاكسي</h1>

        @php
            // 🟡 أيقونات الحالات
            $statusIcons = [
                'pending'   => '⏳',   // قيد الانتظار
                'accepted'  => '📌',   // مقبول
                'ongoing'   => '🚦',   // جاري التنفيذ
                'completed' => '✅',   // مكتمل
                'cancelled' => '❌',   // ملغى
            ];

            // 🎨 ألوان الشارات
            $statusClasses = [
                'pending'   => 'bg-yellow-100 text-yellow-800 border border-yellow-300',
                'accepted'  => 'bg-blue-100 text-blue-800 border border-blue-300',
                'ongoing'   => 'bg-purple-100 text-purple-800 border border-purple-300',
                'completed' => 'bg-green-100 text-green-800 border border-green-300',
                'cancelled' => 'bg-red-100 text-red-800 border border-red-300',
            ];
        @endphp

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">#</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">👤 المستخدم</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">🚖 السائق</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">📍 الموقع</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">⚡ الحالة</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">⭐ التقييم</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">⚙️ الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @foreach($orders as $order)
                        <tr>
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user_id ?? '-' }}</td>
                            <td class="px-4 py-2">
                                {{ $order->driver?->name ?? 'غير محدد' }}
                                <br>
                                <span class="text-xs text-gray-500">{{ $order->driver?->car_number }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="text-xs">📍 {{ $order->pickup_latitude }},{{ $order->pickup_longitude }}</span><br>
                                <span class="text-xs">➡️ {{ $order->dropoff_latitude }},{{ $order->dropoff_longitude }}</span>
                            </td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 text-xs font-semibold rounded {{ $statusClasses[$order->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ $statusIcons[$order->status] ?? '' }}
                                    {{ __("messages.".$order->status) ?? $order->status }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $order->rating ?? '-' }}</td>
                            <td class="px-4 py-2">
                                <form action="{{ route('taxi.order.status', $order->id) }}" method="POST" class="flex items-center gap-1">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="text-sm border rounded p-1">
                                        <option value="pending"   {{ $order->status == 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                                        <option value="accepted"  {{ $order->status == 'accepted' ? 'selected' : '' }}>📌 مقبول</option>
                                        <option value="ongoing"   {{ $order->status == 'ongoing' ? 'selected' : '' }}>🚦 جاري التنفيذ</option>
                                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>✅ مكتمل</option>
                                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>❌ ملغى</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            {{-- ✅ روابط الصفحات --}}
            <div class="p-4">
            </div>
        </div>
    </div>
</x-app-layout>
