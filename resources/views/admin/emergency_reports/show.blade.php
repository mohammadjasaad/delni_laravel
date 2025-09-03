{{-- resources/views/admin/emergency_reports/show.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-4xl mx-auto py-10 px-4">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6 text-center">📄 تفاصيل البلاغ</h1>

        {{-- 🏢 معلومات المركز --}}
        <div class="bg-white p-6 rounded shadow space-y-4 text-sm text-right mb-6">
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">🏢 معلومات المركز</h2>
            <p><strong>الاسم:</strong> {{ $report->service->name ?? '—' }}</p>
            <p><strong>المدينة:</strong> {{ $report->service->city ?? '—' }}</p>
            <p><strong>النوع:</strong> {{ $report->service->type ?? '—' }}</p>
            <p><strong>الموقع:</strong> 
                @if($report->service->latitude && $report->service->longitude)
                    {{ $report->service->latitude }}, {{ $report->service->longitude }}
                @else
                    —
                @endif
            </p>
            @if($report->service->description)
                <p><strong>الوصف:</strong> <span class="text-gray-700">{{ $report->service->description }}</span></p>
            @endif
        </div>

        {{-- 🚨 تفاصيل البلاغ --}}
        <div class="bg-white p-6 rounded shadow space-y-4 text-sm text-right mb-6">
            <h2 class="text-lg font-semibold text-gray-700 border-b pb-2">🚨 تفاصيل البلاغ</h2>
            <p><strong>📅 تاريخ البلاغ:</strong> {{ $report->created_at->format('Y-m-d H:i') }}</p>
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-500',
                    'processing' => 'bg-blue-500',
                    'resolved' => 'bg-green-600',
                    'closed' => 'bg-gray-600',
                ];
                $statusLabels = [
                    'pending' => 'قيد المراجعة',
                    'processing' => 'جارٍ المعالجة',
                    'resolved' => 'تم الحل',
                    'closed' => 'مغلق',
                ];
            @endphp
            <p><strong>📋 الحالة الحالية:</strong>
                <span class="px-2 py-1 rounded text-white text-sm {{ $statusColors[$report->status] ?? 'bg-gray-400' }}">
                    {{ $statusLabels[$report->status] ?? $report->status }}
                </span>
            </p>
            @if($report->reason)
                <p><strong>📝 سبب البلاغ:</strong> {{ $report->reason }}</p>
            @endif
            @if($report->user)
                <p><strong>👤 المبلّغ:</strong> {{ $report->user->name }} ({{ $report->user->email }})</p>
            @endif
        </div>

        {{-- ⚙️ الإجراءات --}}
        <div class="mt-6 flex flex-col md:flex-row justify-between items-center gap-4">
            {{-- تحديث الحالة --}}
            <form method="POST" action="{{ route('admin.emergency_reports.update_status', $report->id) }}" class="flex items-center space-x-2 space-x-reverse">
                @csrf
                <label for="status" class="text-gray-600">🛠️ تحديث الحالة:</label>
                <select name="status" id="status" class="border border-gray-300 rounded px-3 py-2">
                    <option value="pending" {{ $report->status == 'pending' ? 'selected' : '' }}>قيد المراجعة</option>
                    <option value="processing" {{ $report->status == 'processing' ? 'selected' : '' }}>جارٍ المعالجة</option>
                    <option value="resolved" {{ $report->status == 'resolved' ? 'selected' : '' }}>تم الحل</option>
                    <option value="closed" {{ $report->status == 'closed' ? 'selected' : '' }}>مغلق</option>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">💾 تحديث</button>
            </form>

            {{-- حذف البلاغ --}}
            <form method="POST" action="{{ route('admin.emergency_reports.destroy', $report->id) }}" 
                  onsubmit="return confirm('هل أنت متأكد من حذف هذا البلاغ؟')">
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

    {{-- 🗺️ خريطة المركز --}}
    @if ($report->service->latitude && $report->service->longitude)
        <div class="mt-8 text-center">
            <button onclick="toggleMap()" 
                    class="bg-green-600 text-white px-6 py-2 rounded hover:bg-green-700 transition">
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
                        const map = L.map('map').setView([{{ $report->service->latitude }}, {{ $report->service->longitude }}], 14);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(map);
                        L.marker([{{ $report->service->latitude }}, {{ $report->service->longitude }}]).addTo(map)
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
