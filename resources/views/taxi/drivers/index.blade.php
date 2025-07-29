<x-main-layout title="قائمة السائقين">
    <div class="max-w-5xl mx-auto bg-white shadow p-6 rounded mt-6">

        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">🚖 قائمة السائقين المسجلين</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded mb-4 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ زر إضافة --}}
        <div class="text-right mb-4">
            <a href="{{ route('drivers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                ➕ إضافة سائق جديد
            </a>
        </div>

        {{-- ✅ جدول السائقين --}}
        <div class="overflow-x-auto">
            <table class="w-full table-auto border text-center text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">الاسم</th>
                        <th class="p-2 border">🚗 رقم السيارة</th>
                        <th class="p-2 border">🔌 الحالة</th>
                        <th class="p-2 border">📶 الحالة التشغيلية</th>
                        <th class="p-2 border">🌍 الموقع</th>
                        <th class="p-2 border">⚙️ الإجراءات</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach($drivers as $driver)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border">{{ $loop->iteration }}</td>
                        <td class="p-2 border font-semibold">{{ $driver->name }}</td>
                        <td class="p-2 border">{{ $driver->car_number }}</td>

                        {{-- ✅ حالة التفعيل --}}
                        <td class="p-2 border">
                            @if($driver->is_active)
                                <span class="text-green-600 font-semibold">🟢 مُفعّل</span>
                            @else
                                <span class="text-red-600 font-semibold">🔴 غير مفعّل</span>
                            @endif
                        </td>

                        {{-- ✅ الحالة التشغيلية الجديدة --}}
<td class="p-2 border">
    @php
        $statusColors = [
            'متاح' => 'text-green-600',
            'مشغول' => 'text-red-600',
            'غير متصل' => 'text-gray-500',
        ];
    @endphp

    <form action="{{ route('drivers.updateStatus', $driver->id) }}" method="POST">
        @csrf
        <select name="status" onchange="this.form.submit()" class="text-sm px-2 py-1 border rounded bg-gray-50 font-semibold {{ $statusColors[$driver->status] ?? 'text-gray-600' }}">
            @foreach(['متاح', 'مشغول', 'غير متصل'] as $status)
                <option value="{{ $status }}" {{ $driver->status === $status ? 'selected' : '' }}>
                    {{ $status }}
                </option>
            @endforeach
        </select>
    </form>
</td>

                        {{-- ✅ الموقع --}}
                        <td class="p-2 border text-gray-700">
                            {{ $driver->lat ?? 'غير محدد' }}, {{ $driver->lon ?? 'غير محدد' }}
                        </td>

                        {{-- ✅ الإجراءات --}}
                        <td class="p-2 border space-y-1">
                            {{-- زر تغيير الحالة --}}
                            <form action="{{ route('drivers.toggle', $driver->id) }}" method="POST">
                                @csrf
                                <button class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition w-full">
                                    🔄 تغيير التفعيل
                                </button>
                            </form>

                            {{-- زر تعديل --}}
                            <a href="{{ route('drivers.edit', $driver->id) }}" class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition w-full">
                                ✏️ تعديل
                            </a>
                        </td>
                    </tr>
                    @endforeach

                    @if($drivers->isEmpty())
                    <tr>
                        <td colspan="7" class="p-4 text-gray-500">لا يوجد سائقون حالياً.</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</x-main-layout>
