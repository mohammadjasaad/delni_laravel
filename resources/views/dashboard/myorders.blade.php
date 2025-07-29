<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">🚖 {{ __('messages.my_orders') }}</h1>

        {{-- ✅ قسم طلبات التاكسي --}}
        <h2 class="text-lg font-semibold text-yellow-600 mb-2">🚕 {{ __('messages.taxi_orders') }}</h2>
        @if($taxiOrders->count())
            <div class="space-y-4 mb-8">
                @foreach($taxiOrders as $order)
                    <div class="bg-white shadow rounded p-4 border-l-4 border-yellow-500">
                        <p><strong>{{ __('messages.status') }}:</strong> {{ $order->status }}</p>
                        <p><strong>{{ __('messages.driver_name') }}:</strong> {{ $order->driver_name ?? '—' }}</p>
                        <p><strong>{{ __('messages.created_at') }}:</strong> {{ $order->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 mb-6">{{ __('messages.no_taxi_orders') }}</p>
        @endif

        {{-- ✅ قسم بلاغات الطوارئ --}}
        <h2 class="text-lg font-semibold text-red-600 mb-2">🆘 {{ __('messages.emergency_reports') }}</h2>
        @if($emergencyReports->count())
            <div class="space-y-4">
                @foreach($emergencyReports as $report)
                    <div class="bg-white shadow rounded p-4 border-l-4 border-red-500">
                        <p><strong>{{ __('messages.center_name') }}:</strong> {{ $report->center_name }}</p>
                        <p><strong>{{ __('messages.city') }}:</strong> {{ $report->city }}</p>
                        <p><strong>{{ __('messages.report_status') }}:</strong> {{ $report->status ?? 'جديد' }}</p>
                        <p><strong>{{ __('messages.created_at') }}:</strong> {{ $report->created_at->format('Y-m-d H:i') }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500">{{ __('messages.no_emergency_reports') }}</p>
        @endif
    </div>
</x-app-layout>
