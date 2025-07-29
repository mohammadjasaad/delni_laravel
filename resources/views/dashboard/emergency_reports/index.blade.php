<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-yellow-600 text-center mb-8">🚨 البلاغات الواردة على مراكز الطوارئ</h1>

        @if (session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        @if ($reports->isEmpty())
            <p class="text-center text-gray-600">لا توجد بلاغات حالياً.</p>
        @else
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-300 bg-white shadow-md">
                    <thead class="bg-yellow-100 text-gray-800">
                        <tr>
                            <th class="py-3 px-4 border">🏷️ اسم المركز</th>
                            <th class="py-3 px-4 border">🏙️ المدينة</th>
                            <th class="py-3 px-4 border">📄 السبب</th>
                            <th class="py-3 px-4 border">📅 تاريخ البلاغ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $report)
                            <tr class="hover:bg-gray-100">
                                <td class="py-2 px-4 border font-semibold text-gray-700">
                                    {{ $report->service->name ?? 'غير متوفر' }}
                                </td>
                                <td class="py-2 px-4 border text-gray-600">
                                    {{ $report->service->city ?? '-' }}
                                </td>
                                <td class="py-2 px-4 border text-gray-800">
                                    {{ $report->reason }}
                                </td>
                                <td class="py-2 px-4 border text-gray-500 text-sm">
                                    {{ $report->created_at->format('Y-m-d H:i') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
