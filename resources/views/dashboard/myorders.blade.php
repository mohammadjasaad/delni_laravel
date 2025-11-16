<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-gray-800 mb-10 text-center">
            🧾 {{ __('messages.my_orders') }}
        </h1>

        <!-- 🧩 نظام التبويبات -->
        <div x-data="{ tab: 'taxi' }" class="space-y-8">

            <!-- 🔘 أزرار التبويبات -->
            <div class="flex justify-center gap-4 mb-8">
                <button @click="tab = 'taxi'"
                    :class="tab === 'taxi' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-6 py-2 rounded-full font-semibold transition">
                    🚕 طلبات التاكسي
                </button>

                <button @click="tab = 'emergency'"
                    :class="tab === 'emergency' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-6 py-2 rounded-full font-semibold transition">
                    🆘 بلاغات الطوارئ
                </button>

                <button @click="tab = 'mall'"
                    :class="tab === 'mall' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700'"
                    class="px-6 py-2 rounded-full font-semibold transition">
                    🛍️ طلبات المول
                </button>
            </div>

            <!-- 🚖 تبويب التاكسي -->
            <div x-show="tab === 'taxi'" x-transition>
                @if($taxiOrders->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($taxiOrders as $order)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition p-5 border border-yellow-200">
                                <div class="space-y-2">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">
                                        🚖 الحالة:
                                        <span class="text-yellow-600 font-semibold">{{ $order->status }}</span>
                                    </h3>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        👨‍✈️ {{ __('messages.driver_name') }}: {{ $order->driver_name ?? '—' }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        📅 {{ $order->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 bg-gray-100 p-5 rounded-xl text-center">
                        🔕 {{ __('messages.no_taxi_orders') }}
                    </p>
                @endif
            </div>

            <!-- 🆘 تبويب الطوارئ -->
            <div x-show="tab === 'emergency'" x-transition>
                @if($emergencyReports->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($emergencyReports as $report)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition p-5 border border-red-200">
                                <div class="space-y-2">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">
                                        🏥 {{ $report->center_name }}
                                    </h3>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        📍 المدينة: {{ $report->city }}
                                    </p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        الحالة:
                                        <span class="text-red-600">{{ $report->status ?? 'جديد' }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        📅 {{ $report->created_at->format('Y-m-d H:i') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 bg-gray-100 p-5 rounded-xl text-center">
                        🔕 لا توجد بلاغات حالياً
                    </p>
                @endif
            </div>

            <!-- 🛍️ تبويب المول -->
            <div x-show="tab === 'mall'" x-transition>
                @if(isset($orders) && $orders->count())
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($orders as $order)
                            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow hover:shadow-lg transition p-5 border border-green-200 flex flex-col justify-between">
                                <div class="space-y-2">
                                    <h3 class="font-bold text-gray-900 dark:text-white text-lg">
                                        🧾 الطلب رقم #{{ $order->id }}
                                    </h3>
                                    <p class="text-gray-700 dark:text-gray-300">
                                        💰 {{ number_format($order->total) }} ل.س
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        📅 {{ $order->created_at->format('Y-m-d H:i') }}
                                    </p>
                                    <p class="text-sm text-yellow-600">
                                        🕓 الحالة: <span class="font-semibold">{{ $order->status }}</span>
                                    </p>
                                </div>

                                <div class="mt-4 text-right">
                                    <a href="{{ route('dashboard.orders.show', $order->id) }}"
                                       class="inline-block px-5 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-sm font-semibold transition">
                                       👁️ عرض التفاصيل
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 bg-gray-100 p-5 rounded-xl text-center">
                        🔕 لا توجد طلبات مشتريات حالياً
                    </p>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
