{{-- resources/views/dashboard/user-stats.blade.php --}}
<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان + زر تبديل الوضع -->
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-gray-100">
                📊 {{ __('messages.my_statistics') }}
            </h1>
            <button id="toggleDarkMode"
                class="px-4 py-2 rounded-lg bg-gray-200 dark:bg-gray-700 text-gray-800 dark:text-gray-200 shadow hover:scale-105 transition">
                🌙 / ☀️
            </button>
        </div>

        <!-- 📊 بطاقات الإحصائيات -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12">

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl mb-2">📢</div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.my_ads') }}</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $myAdsCount }}</h2>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl mb-2">⭐</div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.featured') }}</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $featuredAdsCount }}</h2>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl mb-2">⚪</div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.normal') }}</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $normalAdsCount }}</h2>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl mb-2">❤️</div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.favorites') }}</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $favoritesCount }}</h2>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl mb-2">🚨</div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.delni_emergency') }}</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $emergencyReportsCount }}</h2>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md hover:shadow-lg transition p-6 text-center">
                <div class="text-4xl mb-2">🚖</div>
                <p class="text-gray-500 dark:text-gray-400">{{ __('messages.my_orders') }}</p>
                <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100">{{ $ordersCount }}</h2>
            </div>
        </div>

        <!-- 🎨 الرسوم البيانية -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- مخطط دائري -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-center mb-4 text-gray-800 dark:text-gray-100">
                    {{ __('messages.my_statistics') }} (Pie)
                </h2>
                <canvas id="pieChart"></canvas>
            </div>

            <!-- مخطط شريطي -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-center mb-4 text-gray-800 dark:text-gray-100">
                    {{ __('messages.my_statistics') }} (Bar)
                </h2>
                <canvas id="barChart"></canvas>
            </div>
        </div>

        <!-- ℹ️ ملاحظات -->
        <div class="bg-yellow-50 dark:bg-yellow-900 border border-yellow-200 dark:border-yellow-700 p-6 rounded-xl text-yellow-800 dark:text-yellow-200 text-center">
            <h3 class="font-bold mb-2">ℹ️ {{ __('messages.info') }}</h3>
            <p>{{ __('messages.my_statistics_desc') }}</p>
        </div>
    </div>

    {{-- ✅ Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const statsData = {
                labels: [
                    "{{ __('messages.my_ads') }}",
                    "{{ __('messages.featured') }}",
                    "{{ __('messages.normal') }}",
                    "{{ __('messages.favorites') }}",
                    "{{ __('messages.delni_emergency') }}",
                    "{{ __('messages.my_orders') }}"
                ],
                datasets: [{
                    label: "{{ __('messages.my_statistics') }}",
                    data: [
                        {{ $myAdsCount }},
                        {{ $featuredAdsCount }},
                        {{ $normalAdsCount }},
                        {{ $favoritesCount }},
                        {{ $emergencyReportsCount }},
                        {{ $ordersCount }}
                    ],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',   // Blue
                        'rgba(234, 179, 8, 0.7)',    // Yellow
                        'rgba(107, 114, 128, 0.7)',  // Gray
                        'rgba(236, 72, 153, 0.7)',   // Pink
                        'rgba(239, 68, 68, 0.7)',    // Red
                        'rgba(16, 185, 129, 0.7)'    // Green
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(107, 114, 128, 1)',
                        'rgba(236, 72, 153, 1)',
                        'rgba(239, 68, 68, 1)',
                        'rgba(16, 185, 129, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            // Pie Chart
            new Chart(document.getElementById('pieChart'), {
                type: 'doughnut',
                data: statsData,
                options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
            });

            // Bar Chart
            new Chart(document.getElementById('barChart'), {
                type: 'bar',
                data: statsData,
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: { y: { beginAtZero: true, ticks: { stepSize: 1 } } }
                }
            });

            // 🌙 زر تبديل الوضع
            const toggleDark = document.getElementById('toggleDarkMode');
            toggleDark.addEventListener('click', () => {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode', document.documentElement.classList.contains('dark') ? 'enabled' : 'disabled');
            });

            // تطبيق الوضع المحفوظ
            if (localStorage.getItem('darkMode') === 'enabled') {
                document.documentElement.classList.add('dark');
            }
        });
    </script>
</x-app-layout>
