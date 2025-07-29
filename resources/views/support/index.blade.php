<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">🎫 تذاكر الدعم الفني</h1>

        {{-- زر إنشاء تذكرة جديدة --}}
        <div class="mb-6">
            <a href="{{ route('support.create') }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 font-semibold">
                ➕ تذكرة جديدة
            </a>
        </div>

        {{-- في حال عدم وجود تذاكر --}}
        @if($tickets->isEmpty())
            <div class="text-gray-600 text-center">لا توجد تذاكر حتى الآن.</div>
        @else
            {{-- جدول عرض التذاكر --}}
            <div class="overflow-x-auto bg-white shadow rounded-lg">
                <table class="min-w-full text-sm text-right text-gray-800">
                    <thead class="bg-gray-100 font-bold">
                        <tr>
                            <th class="px-4 py-3 border">#</th>
                            <th class="px-4 py-3 border">الموضوع</th>
                            <th class="px-4 py-3 border">الحالة</th>
                            <th class="px-4 py-3 border">تاريخ الإنشاء</th>
                            <th class="px-4 py-3 border">رد الإدارة</th> {{-- ✅ العمود الجديد --}}
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $ticket)
                            <tr class="border-t hover:bg-yellow-50">
                                <td class="px-4 py-2 border">{{ $ticket->id }}</td>
                                <td class="px-4 py-2 border">{{ $ticket->subject }}</td>
                                <td class="px-4 py-2 border">

<td class="px-4 py-2 border">
    <a href="{{ route('support.show', $ticket->id) }}" class="text-blue-600 hover:underline">📄 عرض</a>
</td>
                                    @if($ticket->status === 'جديد')
                                        <span class="text-blue-600 font-semibold">جديد</span>
                                    @elseif($ticket->status === 'قيد المعالجة')
                                        <span class="text-yellow-600 font-semibold">قيد المعالجة</span>
                                    @elseif($ticket->status === 'تم الرد')
                                        <span class="text-green-600 font-semibold">تم الرد</span>
                                    @else
                                        <span class="text-gray-600 font-semibold">مغلق</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $ticket->created_at->format('Y-m-d H:i') }}</td>
                                <td class="px-4 py-2 border">
                                    @if($ticket->reply)
                                        <span class="text-green-700 text-xs">{{ Str::limit($ticket->reply, 50) }}</span>
                                    @else
                                        <span class="text-gray-400 italic">لا يوجد رد بعد</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-app-layout>
