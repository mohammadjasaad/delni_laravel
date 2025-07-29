{{-- resources/views/admin/emergency_reports/index.blade.php --}}
<x-app-layout>
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">🚨 إدارة بلاغات مراكز الطوارئ</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 mb-6 rounded text-center shadow">
                {{ session('success') }}
            </div>
        @endif

        @if ($reports->isEmpty())
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-center">
                لا يوجد بلاغات حالياً.
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-xl shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm">
                            <th class="py-3 px-4 text-right">#</th>
                            <th class="py-3 px-4 text-right">اسم المركز</th>
                            <th class="py-3 px-4 text-right">المدينة</th>
                            <th class="py-3 px-4 text-right">النوع</th>
                            <th class="py-3 px-4 text-right">حالة البلاغ</th>
                            <th class="py-3 px-4 text-right">تاريخ البلاغ</th>
                            <th class="py-3 px-4 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($reports as $index => $report)
                            <tr class="border-t hover:bg-gray-50 text-sm">
                                <td class="py-2 px-4">{{ $index + 1 }}</td>
                                <td class="py-2 px-4">{{ $report->service->name ?? 'غير متوفر' }}</td>
                                <td class="py-2 px-4">{{ $report->service->city ?? '—' }}</td>
                                <td class="py-2 px-4">{{ $report->service->type ?? '—' }}</td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 rounded text-white text-xs font-semibold
                                        {{ $report->status === 'جديد' ? 'bg-yellow-500' : 
                                           ($report->status === 'جارٍ المعالجة' ? 'bg-blue-500' : 
                                           ($report->status === 'تم الحل' ? 'bg-green-600' : 'bg-gray-400')) }}">
                                        {{ $report->status }}
                                    </span>
                                </td>
                                <td class="py-2 px-4">{{ $report->created_at->format('Y-m-d H:i') }}</td>
                                <td class="py-2 px-4 text-center">
                                    <div class="flex justify-center items-center space-x-2 rtl:space-x-reverse">
                                        <a href="{{ route('admin.emergency_reports.show', $report->id) }}"
                                           class="text-blue-600 hover:underline text-sm">📋 تفاصيل</a>

                                        <form method="POST" action="{{ route('admin.emergency_reports.destroy', $report->id) }}"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا البلاغ؟')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline text-sm">🗑️ حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
