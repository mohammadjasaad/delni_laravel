<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- ✅ العنوان --}}
        <h1 class="text-3xl font-bold text-center text-red-600 mb-8">🚨 إدارة البلاغات عن مراكز الطوارئ</h1>

        {{-- ✅ رسالة نجاح --}}
        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-3 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ جدول البلاغات --}}
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full text-sm text-gray-800 border border-gray-200">
                <thead class="bg-red-100 text-red-800">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">📍 اسم المركز</th>
                        <th class="px-4 py-2 border">🏙️ المدينة</th>
                        <th class="px-4 py-2 border">⚠️ السبب</th>
                        <th class="px-4 py-2 border">📅 تاريخ الإبلاغ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reports as $report)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border text-center">{{ $report->id }}</td>
                            <td class="px-4 py-2 border">{{ $report->service->name }}</td>
                            <td class="px-4 py-2 border">{{ $report->service->city }}</td>
                            <td class="px-4 py-2 border text-red-700">{{ $report->reason }}</td>
                            <td class="px-4 py-2 border text-center">{{ $report->created_at->format('Y-m-d') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
