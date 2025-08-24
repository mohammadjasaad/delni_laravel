<x-app-layout>
    <!-- ESI: emergency_services/index.blade.php -->
    <div class="max-w-6xl mx-auto px-4 py-8" dir="rtl" x-data="{ showFilters: {{ (request()->filled('city') || request()->filled('type')) ? 'true' : 'false' }} }" x-init="(() => { const s = localStorage.getItem('delni.showFilters'); if (s !== null) showFilters = (s === '1'); })()">
        <style>[x-cloak]{display:none!important}</style>

        <h1 class="text-3xl font-bold text-center text-yellow-600 mb-6">
            🆘 دلني عاجل
        </h1>
        <p class="text-center text-gray-700 mb-6">
            هذه الخدمة تساعدك في العثور على أقرب مركز صيانة سيارات، رافعة، أو خدمة طارئة أثناء الطريق
        </p>

        {{-- زر "أضف مركز جديد" --}}
        <div class="text-center mb-4">
            <a href="{{ route('emergency_services.create') }}"
               class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded shadow transition">
                ➕ أضف مركز جديد
            </a>
        </div>

        {{-- زر إظهار/إخفاء الفلاتر --}}
        <div class="flex items-center justify-center mb-3">
            <button
                type="button"
                class="inline-flex items-center gap-2 text-sm px-3 py-2 rounded border border-gray-300 bg-white hover:bg-gray-50 shadow-sm"
                @click="
                    showFilters = !showFilters;
                    localStorage.setItem('delni.showFilters', showFilters ? '1' : '0');
                    $nextTick(() => {
                        try { window.__emergencyMap?.invalidateSize?.(true) } catch(e) {}
                        setTimeout(() => { try { window.__emergencyMap?.invalidateSize?.(true) } catch(e) {} }, 300);
                    })
                "
            >
                <span x-show="!showFilters">إظهار الفلاتر</span>
                <span x-show="showFilters">إخفاء الفلاتر</span>
            </button>
        </div>

        {{-- نموذج الفلترة --}}
        @php
            $filterAction = \Route::has('emergency_services.index')
                ? route('emergency_services.index')
                : (\Route::has('emergency.index') ? route('emergency.index') : url('/emergency-services'));
        @endphp

        <div class="bg-white rounded-lg shadow p-4 mb-6" x-cloak x-show="showFilters" x-transition>
            <form method="GET" action="{{ $filterAction }}" class="flex flex-wrap gap-4 justify-center items-center">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">🏙️ المدينة</label>
                    <input type="text" name="city" value="{{ request('city') }}"
                           class="border border-gray-300 rounded px-3 py-2" placeholder="دمشق، حلب...">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">🛠️ نوع المركز</label>
                    <select name="type" class="border border-gray-300 rounded px-3 py-2">
                        <option value="">الكل</option>
                        <option value="رافعة" {{ request('type') == 'رافعة' ? 'selected' : '' }}>رافعة</option>
                        <option value="مركز صيانة" {{ request('type') == 'مركز صيانة' ? 'selected' : '' }}>مركز صيانة</option>
                    </select>
                </div>

                <div class="mt-6">
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                        🔍 فلترة
                    </button>
                </div>

                <div class="mt-6">
                    <a href="{{ $filterAction }}"
                       class="text-gray-600 hover:text-black underline text-sm">↩️ إعادة تعيين</a>
                </div>
            </form>
        </div>

        {{-- الخريطة --}}
        <div id="emergencyMap" class="w-full h-[500px] rounded-lg shadow-md mb-10"></div>

        {{-- شبكة المراكز --}}
        @php
            $items = \Illuminate\Support\Collection::wrap($services ?? $emergencyServices ?? $data ?? []);
        @endphp

        @if ($items->isNotEmpty())
            <div id="cardsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($items as $service)
                    @php $sid = $service->id ?? $service['id'] ?? 0; @endphp

                    <div class="bg-white border border-yellow-300 p-4 rounded-lg shadow hover:shadow-lg transition relative">
                        <h2 class="text-lg font-bold text-gray-800 mb-1">🔧 {{ $service->name ?? $service['name'] ?? '—' }}</h2>
                        <p class="text-sm text-gray-600">📍 {{ $service->city ?? $service['city'] ?? '—' }}</p>
                        <p class="text-sm text-gray-500">🛠️ النوع: {{ $service->type ?? $service['type'] ?? '—' }}</p>
                        <p class="text-xs text-gray-400 mt-2">
                            📌 الإحداثيات:
                            {{ $service->lat ?? $service['lat'] ?? '—' }},
                            {{ $service->lng ?? $service['lng'] ?? '—' }}
                        </p>

                        <p id="distance-{{ $sid }}" class="text-xs text-gray-500 mt-1">📏 المسافة: غير معروفة</p>

                        <a href="{{ route('emergency_services.show', $sid) }}"
                           class="inline-block mt-3 text-sm text-yellow-600 hover:underline font-semibold">
                            👁️ عرض التفاصيل
                        </a>

                        <button onclick="openReportModal({{ $sid }})"
                                class="block text-red-600 hover:text-red-800 text-sm font-semibold mt-1">
                            🚫 أبلغ عن هذا المركز
                        </button>

                        <div class="absolute top-2 end-2 flex gap-3">
                            <a href="{{ route('emergency_services.edit', $sid) }}"
                               class="text-blue-600 hover:text-blue-800 font-semibold text-sm">✏️</a>
                            <form method="POST" action="{{ route('emergency_services.destroy', $sid) }}"
                                  onsubmit="return confirm('هل أنت متأكد أنك تريد حذف هذا المركز؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-semibold text-sm">🗑️</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-white rounded-lg shadow p-8 text-center text-gray-600">
                لا توجد مراكز مطابقة الآن. جرّب توسيع الفلترة أو أضف مركزًا جديدًا.
            </div>
        @endif
    </div>

    {{-- زر تحديد موقعي --}}
    <div class="text-center my-6">
        <button id="locateBtn" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded shadow">
            📍 حدد موقعي
        </button>
    </div>

    {{-- Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- سكربت الخريطة --}}
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('emergencyMap').setView(34.8021, 38.9968], 7);
        window.__emergencyMap = map;

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const params = new URLSearchParams(window.location.search);
        const city = params.get('city') || '';
        const type = params.get('type') || '';

        let servicesData = [];
        fetch(`{{ route('emergency_services.mapData') }}?city=${encodeURIComponent(city)}&type=${encodeURIComponent(type)}`)
            .then(r => r.json())
            .then(data => {
                servicesData = Array.isArray(data) ? data : [];
                servicesData.forEach(svc => {
                    if (!svc.lat || !svc.lng) return;
                    const m = L.marker(svc.lat, svc.lng]).addTo(map);
                    m.bindPopup(`
                        <strong>🔧 ${svc.name ?? 'خدمة طوارئ'}</strong><br>
                        🛠️ النوع: ${svc.type ?? '—'}<br>
                        📍 المدينة: ${svc.city ?? '—'}<br>
                        📏 المسافة: <span id="popup-distance-${svc.id}">غير معروفة</span>
                    `);
                });
            });

        document.getElementById('locateBtn').addEventListener('click', function () {
            if (!navigator.geolocation) return alert("المتصفح لا يدعم تحديد الموقع الجغرافي.");
            navigator.geolocation.getCurrentPosition(function (pos) {
                const userLat = pos.coords.latitude;
                const userLng = pos.coords.longitude;

                L.marker(userLat, userLng]).addTo(map).bindPopup("📍 أنت هنا").openPopup();
                map.setView(userLat, userLng], 13);

                servicesData.forEach(svc => {
                    if (!svc.lat || !svc.lng) return;
                    const dist = haversine(userLat, userLng, svc.lat, svc.lng);
                    svc.distance = dist;

                    const el = document.getElementById('distance-' + svc.id);
                    if (el) el.textContent = `📏 المسافة: ${dist.toFixed(2)} كم`;

                    const popupEl = document.getElementById('popup-distance-' + svc.id);
                    if (popupEl) popupEl.textContent = `${dist.toFixed(2)} كم`;
                });

                const container = document.getElementById('cardsGrid');
                if (container) {
                    const cards = Array.from(container.children);
                    const mapById = {};
                    cards.forEach(card => {
                        const distEl = card.querySelector('[id^="distance-"]');
                        if (distEl) {
                            const id = distEl.id.split('-')[1];
                            mapById[id] = card;
                        }
                    });
                    container.innerHTML = '';
                    servicesData
                        .filter(s => mapById[s.id])
                        .sort((a,b) => (a.distance ?? 1e9) - (b.distance ?? 1e9))
                        .forEach(s => container.appendChild(mapById[s.id]));
                }
            }, () => alert("فشل في تحديد الموقع."));
        });

        function haversine(lat1, lon1, lat2, lon2) {
            const R = 6371, toRad = d => d * Math.PI / 180;
            const dLat = toRad(lat2 - lat1), dLon = toRad(lon2 - lon1);
            const a = Math.sin(dLat/2)**2 + Math.cos(toRad(lat1))*Math.cos(toRad(lat2))*Math.sin(dLon/2)**2;
            return 2 * R * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
        }
    });

    function openReportModal(id){
        const el = document.getElementById('reportServiceId');
        const modal = document.getElementById('reportModal');
        if (!el || !modal) return;
        el.value = id;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    function closeReportModal(){
        const modal = document.getElementById('reportModal');
        if (!modal) return;
        modal.classList.remove('flex');
        modal.classList.add('hidden');
    }
    </script>

    {{-- Modal الإبلاغ --}}
    <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg shadow-xl p-6 max-w-sm w-full">
            <h2 class="text-lg font-bold text-gray-800 mb-4">🚫 تأكيد الإبلاغ</h2>
            <p class="text-sm text-gray-700 mb-4">سيتم مراجعة البلاغ من قبل فريق الدعم.</p>

            <form method="POST" action="{{ route('emergency_reports.store') }}">
                @csrf
                <input type="hidden" name="service_id" id="reportServiceId">
                <textarea name="reason" rows="3" required class="w-full border border-gray-300 rounded px-3 py-2 text-sm mb-4" placeholder="سبب الإبلاغ..."></textarea>

                <div class="flex justify-end gap-3">
                    <button type="button" onclick="closeReportModal()" class="text-gray-600 hover:text-black">❌ إلغاء</button>
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold px-4 py-2 rounded">✅ أبلغ</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
