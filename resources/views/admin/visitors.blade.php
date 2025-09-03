{{-- resources/views/admin/visitors.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-yellow-600 mb-10 text-center">
            👥 {{ __('messages.visitors') }}
        </h1>

        <!-- 📊 بطاقات -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6 text-center mb-12">
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.visitors_count') }} ({{ __('messages.today') }})</p>
                <h2 class="text-3xl font-extrabold text-blue-600">{{ $todayVisitors }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.visitors_count') }} (7 أيام)</p>
                <h2 class="text-3xl font-extrabold text-green-600">{{ $weekVisitors }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.visitors_count') }} (30 يوم)</p>
                <h2 class="text-3xl font-extrabold text-yellow-600">{{ $monthVisitors }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow p-6">
                <p class="text-gray-500">{{ __('messages.visitors_count') }} (إجمالي)</p>
                <h2 class="text-3xl font-extrabold text-gray-800">{{ $totalVisitors }}</h2>
            </div>
        </div>

        <!-- 📈 مخطط الزوار -->
        <div class="bg-white rounded-xl shadow p-6 mb-12">
            <h2 class="text-xl font-bold text-center mb-4">📈 {{ __('messages.visitors_count') }} (آخر 7 أيام)</h2>
            <canvas id="visitorsChart"></canvas>
        </div>

        <!-- 📋 جدول الزوار -->
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-xl font-bold mb-4">📋 {{ __('messages.visitors') }}</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full border text-center text-sm">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border-b">{{ __('messages.page') }}</th>
                            <th class="px-4 py-2 border-b">{{ __('messages.visitors_count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topPages as $page)
                            <tr>
                                <td class="px-4 py-2 border-b">{{ $page->page }}</td>
                                <td class="px-4 py-2 border-b">{{ $page->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="px-4 py-4 text-gray-500">
                                    {{ __('messages.no_visitors') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- ✅ Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const ctx = document.getElementById('visitorsChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($last7DaysLabels),
                    datasets: [{
                        label: "{{ __('messages.visitors') }}",
                        data: @json($last7DaysData),
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: 'rgba(59, 130, 246, 1)'
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
