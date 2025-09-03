{{-- resources/views/admin/taxi_orders/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">🚖 قائمة طلبات Delni Taxi</h1>

        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-100 text-gray-700 text-sm">
                    <tr>
                        <th class="px-4 py-2 text-left">#</th>
                        <th class="px-4 py-2 text-left">الراكب</th>
                        <th class="px-4 py-2 text-left">السائق</th>
                        <th class="px-4 py-2 text-left">الحالة</th>
                        <th class="px-4 py-2 text-left">تاريخ الطلب</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 text-sm">
                    @forelse($orders as $order)
                        <tr>
                            <td class="px-4 py-2">{{ $order->id }}</td>
                            <td class="px-4 py-2">{{ $order->user_name }}</td>
                            <td class="px-4 py-2">{{ $order->driver->name ?? 'غير معروف' }}</td>
                            <td class="px-4 py-2">{{ $order->status }}</td>
                            <td class="px-4 py-2">{{ $order->created_at->format('Y-m-d H:i') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center px-4 py-4 text-gray-500">لا يوجد طلبات حالياً.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
