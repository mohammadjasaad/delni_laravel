<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-gray-800 mb-8 text-center">
            🚖🆘 {{ __('messages.my_orders') }}
        </h1>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- 🚖 قسم طلبات التاكسي -->
            <div>
                <h2 class="text-xl font-semibold text-yellow-600 mb-4 flex items-center gap-2">
                    🚕 {{ __('messages.taxi_orders') }}
                </h2>

                @if($taxiOrders->count())
                    <div class="space-y-4">
                        @foreach($taxiOrders as $order)
                            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-yellow-500 hover:shadow-md transition">
                                <p class="text-gray-800"><strong>{{ __('messages.status') }}:</strong> {{ $order->status }}</p>
                                <p class="text-gray-700"><strong>{{ __('messages.driver_name') }}:</strong> {{ $order->driver_name ?? '—' }}</p>
                                <p class="text-gray-600 text-sm"><strong>{{ __('messages.created_at') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 bg-gray-100 p-4 rounded text-center">
                        🔕 {{ __('messages.no_taxi_orders') }}
                    </p>
                @endif
            </div>

            <!-- 🆘 قسم بلاغات الطوارئ -->
            <div>
                <h2 class="text-xl font-semibold text-red-600 mb-4 flex items-center gap-2">
                    🆘 {{ __('messages.emergency_reports') }}
                </h2>

                @if($emergencyReports->count())
                    <div class="space-y-4">
                        @foreach($emergencyReports as $report)
                            <div class="bg-white shadow rounded-lg p-4 border-l-4 border-red-500 hover:shadow-md transition">
                                <p class="text-gray-800"><strong>{{ __('messages.center_name') }}:</strong> {{ $report->center_name }}</p>
                                <p class="text-gray-700"><strong>{{ __('messages.city') }}:</strong> {{ $report->city }}</p>
                                <p class="text-gray-700"><strong>{{ __('messages.report_status') }}:</strong> {{ $report->status ?? __('messages.new_report') }}</p>
                                <p class="text-gray-600 text-sm"><strong>{{ __('messages.created_at') }}:</strong> {{ $report->created_at->format('Y-m-d H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 bg-gray-100 p-4 rounded text-center">
                        🔕 {{ __('messages.no_emergency_reports') }}
                    </p>
                @endif
            </div>
        </div>

    </div>
</x-app-layout>
