{{-- resources/views/admin/emergency-dashboard.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-red-600 mb-10 text-center">
            🚨 {{ __('messages.emergency_reports') }}
        </h1>

        <!-- 📊 بطاقات -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 text-center mb-12">
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">{{ __('messages.emergency_reports_count') }}</p>
                <h2 class="text-3xl font-extrabold text-gray-800">{{ $totalReports }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">🆕 {{ __('messages.new') }}</p>
                <h2 class="text-3xl font-extrabold text-blue-600">{{ $newReports }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">⚙️ {{ __('messages.in_progress') }}</p>
                <h2 class="text-3xl font-extrabold text-yellow-600">{{ $inProgressReports }}</h2>
            </div>
            <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition p-6">
                <p class="text-gray-500">✅ {{ __('messages.completed') }}</p>
                <h2 class="text-3xl font-extrabold text-green-600">{{ $completedReports }}</h2>
            </div>
        </div>

        <!-- 🎨 الرسوم البيانية -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <!-- Pie Chart -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-center mb-4">{{ __('messages.statistics') }} (Pie)</h2>
                <canvas id="reportsPieChart"></canvas>
            </div>

            <!-- Bar Chart -->
            <div class="bg-white rounded-xl shadow p-6">
                <h2 class="text-xl font-bold text-center mb-4">{{ __('messages.statistics') }} (Bar)</h2>
                <canvas id="reportsBarChart"></canvas>
            </div>
        </div>

        <!-- ℹ️ ملاحظات -->
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-6 rounded-xl text-center">
            <h3 class="font-bold mb-2">ℹ️ {{ __('messages.info') }}</h3>
            <p>🚑 {{ __('messages.emergency_statistics_desc') }}</p>
        </div>
    </div>

    {{-- ✅ Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const reportsData = {
                labels: [
                    "{{ __('messages.new') }}",
                    "{{ __('messages.in_progress') }}",
                    "{{ __('messages.completed') }}"
                ],
                datasets: [{
                    label: "{{ __('messages.emergency_reports') }}",
                    data: [
                        {{ $newReports }},
                        {{ $inProgressReports }},
                        {{ $completedReports }}
                    ],
                    backgroundColor: [
                        'rgba(59, 130, 246, 0.7)',  // Blue
                        'rgba(234, 179, 8, 0.7)',   // Yellow
                        'rgba(34, 197, 94, 0.7)'    // Green
                    ],
                    borderColor: [
                        'rgba(59, 130, 246, 1)',
                        'rgba(234, 179, 8, 1)',
                        'rgba(34, 197, 94, 1)'
                    ],
                    borderWidth: 2
                }]
            };

            // Pie Chart
            new Chart(document.getElementById('reportsPieChart'), {
                type: 'doughnut',
                data: reportsData,
                options: {
                    responsive: true,
                    plugins: { legend: { position: 'bottom' } }
                }
            });

            // Bar Chart
            new Chart(document.getElementById('reportsBarChart'), {
                type: 'bar',
                data: reportsData,
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
