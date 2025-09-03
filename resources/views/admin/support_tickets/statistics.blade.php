{{-- resources/views/admin/support_tickets/statistics.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-6">

        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-extrabold text-yellow-600 mb-8 text-center">
            🎫 {{ __('messages.support_tickets_statistics') }}
        </h1>

        {{-- ✅ بطاقات إحصائية --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 mb-10">
            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-bold text-gray-700">📊 {{ __('messages.total_tickets') }}</h2>
                <p class="text-3xl font-extrabold text-blue-600">{{ $total }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-bold text-gray-700">🆕 {{ __('messages.ticket_status_new') }}</h2>
                <p class="text-3xl font-extrabold text-yellow-600">{{ $new }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-bold text-gray-700">⚙️ {{ __('messages.ticket_status_processing') }}</h2>
                <p class="text-3xl font-extrabold text-orange-600">{{ $processing }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-bold text-gray-700">✅ {{ __('messages.ticket_status_answered') }}</h2>
                <p class="text-3xl font-extrabold text-green-600">{{ $answered }}</p>
            </div>

            <div class="bg-white p-6 rounded-xl shadow text-center">
                <h2 class="text-lg font-bold text-gray-700">🚫 {{ __('messages.ticket_status_closed') }}</h2>
                <p class="text-3xl font-extrabold text-red-600">{{ $closed }}</p>
            </div>
        </div>

        {{-- 📊 الرسم البياني --}}
        <div class="bg-white p-6 rounded-xl shadow mb-10">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📈 {{ __('messages.tickets_distribution') }}</h2>
            <canvas id="ticketsChart" height="100"></canvas>
        </div>

        {{-- 📜 آخر 5 تذاكر --}}
        <div class="bg-white p-6 rounded-xl shadow">
            <h2 class="text-lg font-bold text-gray-800 mb-4">📜 {{ __('messages.latest_tickets') }}</h2>
            <ul class="divide-y divide-gray-200">
                @forelse($latestTickets as $ticket)
                    <li class="py-3 flex justify-between items-center">
                        <span class="text-gray-700">#{{ $ticket->id }} - {{ $ticket->subject }}</span>
                        <a href="{{ route('admin.support_tickets.show', $ticket->id) }}"
                           class="text-sm text-yellow-600 hover:underline">👁️ {{ __('messages.view_details') }}</a>
                    </li>
                @empty
                    <li class="py-3 text-gray-500">{{ __('messages.no_tickets') }}</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- 📊 Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('ticketsChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: [
                    '{{ __("messages.ticket_status_new") }}',
                    '{{ __("messages.ticket_status_processing") }}',
                    '{{ __("messages.ticket_status_answered") }}',
                    '{{ __("messages.ticket_status_closed") }}'
                ],
                datasets: [{
                    data: [{{ $new }}, {{ $processing }}, {{ $answered }}, {{ $closed }}],
                    backgroundColor: ['#facc15', '#fb923c', '#22c55e', '#ef4444'],
                }]
            }
        });
    </script>
</x-app-layout>
