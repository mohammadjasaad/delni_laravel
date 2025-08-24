<x-app-layout>
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">📄 تفاصيل البلاغ</h1>

        <div class="bg-white p-6 rounded shadow space-y-4 text-sm text-right">
            <p><strong>🏢 اسم المركز:</strong> {{ $report->service->name ?? '—' }}</p>
            <p><strong>🏙️ المدينة:</strong> {{ $report->service->city ?? '—' }}</p>
            <p><strong>🛠️ النوع:</strong> {{ $report->service->type ?? '—' }}</p>
            <p><strong>📌 الموقع:</strong> 
                @if($report->service->latitude && $report->service->longitude)
                    {{ $report->service->latitude }}, {{ $report->service->longitude }}
                @else
                    —
                @endif
            </p>
            <p><strong>📅 تاريخ البلاغ:</strong> {{ $report->created_at->format('Y-m-d H:i') }}</p>

            <p><strong>📋 الحالة الحالية:</strong>
                <span class="px-2 py-1 rounded text-white text-sm
                    {{ $report->status === 'جديد' ? 'bg-yellow-500' : ($report->status === 'جارٍ المعالجة' ? 'bg-blue-500' : 'bg-green-600') }}">
                    {{ $report->status }}
                </span>
            </p>

            @if($report->service->description)
                <p><strong>📝 وصف المركز:</strong> <span class="text-gray-700">{{ $report->service->description }}</span></p>
            @endif
        </div>

        <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">

            {{-- تحديث الحالة --}}
            <form method="POST" action="{{ route('admin.emergency_reports.update_status', $report->id) }}" class="flex items-center space-x-2 space-x-reverse">
                @csrf
                <label for="status" class="text-gray-600">🛠️ تحديث الحالة:</label>
                <select name="status" id="status" class="border border-gray-300 rounded px-3 py-2">
                    <option value="جديد" {{ $report->status == 'جديد' ? 'selected' : '' }}>جديد</option>
                    <option value="جارٍ المعالجة" {{ $report->status == 'جارٍ المعالجة' ? 'selected' : '' }}>جارٍ المعالجة</option>
                    <option value="تم الحل" {{ $report->status == 'تم الحل' ? 'selected' : '' }}>تم الحل</option>
                </select>
                <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">💾 تحديث</button>
            </form>

            {{-- حذف البلاغ --}}
            <form method="POST" action="{{ route('admin.emergency_reports.destroy', $report->id) }}" onsubmit="return confirm('هل أنت متأكد من حذف هذا البلاغ؟')">
                @csrf
                @method('DELETE')
                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600">🗑️ حذف</button>
            </form>
        </div>

        {{-- زر الرجوع --}}
        <div class="mt-8 text-center">
            <a href="{{ route('admin.emergency_reports.index') }}" 
               class="inline-block bg-gray-200 text-gray-800 px-6 py-2 rounded hover:bg-gray-300 transition">
               ← رجوع إلى قائمة البلاغات
            </a>
        </div>
    </div>
{{-- خريطة المركز --}}
@if ($report->service->latitude && $report->service->longitude)
    <div class="mt-8 text-center">
        <button onclick="toggleMap()" 
                class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition">
            🗺️ عرض موقع المركز على الخريطة
        </button>

        <div id="map" class="mt-4 rounded shadow hidden h-64"></div>
    </div>

    {{-- Leaflet.js --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <script>
        function toggleMap() {
            const mapDiv = document.getElementById('map');
            if (mapDiv.classList.contains('hidden')) {
                mapDiv.classList.remove('hidden');
                if (!window.mapInitialized) {
                    const map = L.map('map').setView({{ $report->service->latitude }}, {{ $report->service->longitude }}], 14);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                    }).addTo(map);
                    L.marker({{ $report->service->latitude }}, {{ $report->service->longitude }}]).addTo(map)
                        .bindPopup("📍 مركز الطوارئ: {{ $report->service->name }}").openPopup();
                    window.mapInitialized = true;
                }
            } else {
                mapDiv.classList.add('hidden');
            }
        }
    </script>
@endif
</x-app-layout>
