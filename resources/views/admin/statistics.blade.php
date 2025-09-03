{{-- resources/views/admin/statistics.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-yellow-600 mb-10 text-center">
            📊 {{ __('messages.statistics') }}
        </h1>

        <!-- 📊 البطاقات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-12">
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">{{ __('messages.ads_count') }}</p>
                <h2 class="text-3xl font-extrabold text-gray-800">{{ $adsCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">{{ __('messages.featured_ads') }}</p>
                <h2 class="text-3xl font-extrabold text-yellow-500">{{ $featuredAdsCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">{{ __('messages.users_count') }}</p>
                <h2 class="text-3xl font-extrabold text-green-600">{{ $usersCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">{{ __('messages.emergency_statistics') }}</p>
                <h2 class="text-3xl font-extrabold text-red-600">{{ $emergencyCentersCount }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">{{ __('messages.emergency_reports_count') }}</p>
                <h2 class="text-3xl font-extrabold text-pink-600">{{ $reportsCount }}</h2>
            </div>
        </div>

        <!-- 🎨 الرسوم البيانية -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Pie Chart -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-center mb-4">{{ __('messages.statistics') }} (Pie)</h2>
                <canvas id="pieChart"></canvas>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-center mb-4">{{ __('messages.statistics') }} (Bar)</h2>
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- 🏙️ المدن الأكثر نشاطاً -->
        <div class="bg-white rounded-xl shadow p-6 mb-12">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-4">🏙️ {{ __('messages.city') }}</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full text-center border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b">{{ __('messages.city') }}</th>
                            <th class="py-2 px-4 border-b">{{ __('messages.ads_count') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($topCities as $city)
                            <tr>
                                <td class="py-2 px-4 border-b">{{ $city->city }}</td>
                                <td class="py-2 px-4 border-b">{{ $city->total }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="py-4 text-gray-500">{{ __('messages.no_ads_found') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- ℹ️ مستقبل -->
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-xl text-center">
            <h3 class="font-bold mb-2">🚀 {{ __('messages.info') }}</h3>
            <ul class="list-disc list-inside text-sm md:text-base space-y-1">
                <li>📈 {{ __('messages.statistics_desc') }}</li>
                <li>📂 {{ __('messages.categories') }}</li>
                <li>⏱️ متوسط زمن الاستجابة للبلاغات</li>
                <li>🧭 توزيع الإعلانات على الخريطة</li>
            </ul>
        </div>
    </div>

    {{-- ✅ Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const statsData = {
                labels: [
                    "{{ __('messages.ads') }}",
                    "{{ __('messages.featured_ads') }}",
                    "{{ __('messages.users_count') }}",
                    "{{ __('messages.emergency_statistics') }}",
                    "{{ __('messages.emergency_reports_count') }}"
                ],
                datasets: [{
                    label: "{{ __('messages.statistics') }}",
                    data: [
                        {{ $adsCount }},
                        {{ $featuredAdsCount }},
                        {{ $usersCount }},
                        {{ $emergencyCentersCount }},
                        {{ $reportsCount }}
                    ],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',  // Blue
                        'rgba(234, 179, 8, 0.7)',   // Yellow
                        'rgba(34, 197, 94, 0.7)',   // Green
                        'rgba(239, 68, 68, 0.7)',   // Red
                        'rgba(236, 72, 153, 0.7)'   // Pink
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(34, 197, 94, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(236, 72, 153, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            // Pie Chart
            new Chart(document.getElementById('pieChart'), {
                type: 'doughnut',
                data: statsData,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });

            // Bar Chart
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: statsData,
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
