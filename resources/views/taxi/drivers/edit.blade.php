<x-main-layout title="تعديل بيانات السائق">
    <div class="max-w-xl mx-auto bg-white shadow p-6 rounded mt-6">
        <h1 class="text-2xl font-bold text-yellow-600 mb-4 text-center">✏️ تعديل بيانات السائق</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-800 p-3 rounded mb-4">
                <ul class="list-disc pl-5 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('drivers.update', $driver->id) }}">
            @csrf
            @method('PUT')

            {{-- الاسم --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">اسم السائق:</label>
                <input type="text" name="name" value="{{ old('name', $driver->name) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>

            {{-- رقم السيارة --}}
            <div class="mb-4">
                <label class="block text-gray-700 font-semibold mb-1">رقم السيارة:</label>
                <input type="text" name="car_number" value="{{ old('car_number', $driver->car_number) }}" class="w-full border border-gray-300 rounded px-3 py-2" required>
            </div>
{{-- الحالة --}}
<div class="mb-4">
    <label class="block text-gray-700 font-semibold mb-1">⚙️ حالة السائق:</label>
    <select name="status" class="w-full border border-gray-300 rounded px-3 py-2">
        @foreach(['متاح', 'مشغول', 'غير متصل'] as $status)
            <option value="{{ $status }}" {{ $driver->status === $status ? 'selected' : '' }}>
                {{ $status }}
            </option>
        @endforeach
    </select>
</div>
            {{-- الموقع --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">📍 Latitude:</label>
                    <input type="text" name="lat" value="{{ old('lat', $driver->lat) }}" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">📍 Longitude:</label>
                    <input type="text" name="lon" value="{{ old('lon', $driver->lon) }}" class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
                    💾 حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</x-main-layout>
