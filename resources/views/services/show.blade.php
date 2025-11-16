{{-- resources/views/services/show.blade.php --}}
<x-app-layout>
<div class="w-full">

    {{-- ✅ بانر الخدمة --}}
    <div class="w-full h-64 bg-cover bg-center rounded-xl shadow-md"
         style="background-image: url('{{ $banner }}');"></div>

    <div class="max-w-7xl mx-auto px-4 py-8">

        {{-- عنوان + تقييم --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">{{ $serviceTitle }}</h1>

            @if($ratingsCount > 0)
                <div class="flex items-center gap-2 text-yellow-500 text-xl">
                    ⭐ {{ number_format($averageRating,1) }}
                    <span class="text-gray-600 text-sm">({{ $ratingsCount }} تقييم)</span>
                </div>
            @else
                <span class="text-gray-500 text-sm">لا توجد تقييمات حالياً</span>
            @endif
        </div>

{{-- 🎚️ شريط الفلاتر --}}
<form method="GET" action="{{ route('services.show', $subcategory) }}" class="bg-white shadow p-4 rounded-xl mb-8 grid grid-cols-1 md:grid-cols-5 gap-4">

    {{-- المدينة --}}
    <select name="city" class="border rounded-xl p-3">
        <option value="">كل المدن</option>
        @foreach($allCities as $city)
            <option value="{{ $city }}" {{ request('city') == $city ? 'selected' : '' }}>{{ $city }}</option>
        @endforeach
    </select>

    {{-- السعر من --}}
    <input type="number" name="min_price" class="border rounded-xl p-3" placeholder="السعر الأدنى" value="{{ request('min_price') }}">

    {{-- السعر إلى --}}
    <input type="number" name="max_price" class="border rounded-xl p-3" placeholder="السعر الأعلى" value="{{ request('max_price') }}">

    {{-- الترتيب --}}
    <select name="sort" class="border rounded-xl p-3">
        <option value="">الترتيب</option>
        <option value="price_asc"  {{ request('sort') == 'price_asc'  ? 'selected' : '' }}>السعر: من الأقل إلى الأعلى</option>
        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>السعر: من الأعلى إلى الأقل</option>
    </select>

    {{-- زر --}}
    <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl font-semibold">
        🔍 عرض النتائج
    </button>
</form>

{{-- زر إعادة تعيين --}}
@if(request()->has('city') || request()->has('min_price') || request()->has('max_price') || request()->has('sort'))
    <a href="{{ route('services.show', $subcategory) }}" class="text-sm text-blue-600 underline mb-4 block">
        ♻️ إعادة تعيين الفلاتر
    </a>
@endif

        {{-- متوسط السعر --}}
        <div class="bg-white shadow rounded-xl p-4 mb-8 border border-gray-200">
            <div class="text-gray-700 text-lg">
                متوسط سعر الخدمة:
                <span class="font-bold text-yellow-600">{{ number_format($averagePrice, 0) }} ل.س</span>
            </div>
        </div>

        {{-- 🗺️ خريطة + البطاقات --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">

            {{-- الخريطة --}}
            <div class="col-span-1 lg:col-span-8">
                <div id="map" class="w-full h-[500px] rounded-xl shadow border"></div>
            </div>

            {{-- قائمة المزودين --}}
<div class="col-span-1 lg:col-span-4 space-y-4 max-h-[500px] overflow-y-auto pr-2">

@forelse($adsWithLocation as $ad)
    <div class="bg-white rounded-xl shadow hover:shadow-lg transition p-4 border service-card"
         data-lat="{{ $ad->lat }}" data-lng="{{ $ad->lng }}">

        {{-- صورة الإعلان --}}
        @php
            $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
            $firstImage = $images[0] ?? null;
        @endphp

        @if($firstImage)
            <img src="{{ asset('storage/'.$firstImage) }}" class="w-full h-40 object-cover rounded-lg mb-3">
        @else
            <img src="{{ asset('images/no-image.png') }}" class="w-full h-40 object-cover rounded-lg mb-3">
        @endif

        {{-- بيانات المزوّد --}}
        <div class="flex items-center gap-3 mb-3">
            <img src="{{ $ad->user->avatar ? asset('storage/'.$ad->user->avatar) : asset('images/default-avatar.png') }}"
                 class="w-10 h-10 rounded-full border shadow">
            <div>
                <h4 class="font-semibold text-gray-800">{{ $ad->user->name }}</h4>
                <p class="text-gray-500 text-xs"><i class="fas fa-map-marker-alt"></i> {{ $ad->city }}</p>
            </div>
        </div>

@php
    $userRatingAvg = \App\Models\ServiceRating::where('user_id', $ad->user->id)->avg('stars') ?? 0;
    $userRatingCount = \App\Models\ServiceRating::where('user_id', $ad->user->id)->count();
@endphp

@if($userRatingCount > 0)
    <div class="text-yellow-500 text-sm mb-3">
        ⭐ {{ number_format($userRatingAvg, 1) }} <span class="text-gray-500 text-xs">({{ $userRatingCount }} تقييم)</span>
    </div>
@else
    <div class="text-gray-400 text-xs mb-3">
        لا توجد تقييمات بعد
    </div>
@endif

        {{-- العنوان + السعر --}}
        <h3 class="font-bold text-lg text-gray-900">{{ $ad->title }}</h3>
        <p class="text-yellow-600 font-semibold text-md mb-3">{{ number_format($ad->price,0) }} ل.س</p>

        {{-- أزرار --}}
        <a href="{{ route('ads.show', $ad->id) }}"
           class="block text-center bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-xl text-sm font-semibold mb-2">
            👀 عرض الإعلان
        </a>

        @if($ad->user->phone)
            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $ad->user->phone) }}?text={{ urlencode('مرحباً، أود الاستفسار حول: '.$ad->title) }}"
               target="_blank"
               class="block text-center bg-green-500 hover:bg-green-600 text-white py-2 rounded-xl text-sm font-semibold">
                💬 واتساب
            </a>
        @endif

    </div>
@empty
    <p class="text-gray-400 text-center mt-10">لا يوجد مقدمي خدمة حالياً.</p>
@endforelse

</div>

        </div>

{{-- ✅ عرض تقييم المستخدم إن وجد --}}
@if($userRating)
<div class="p-4 mb-6 border-2 border-yellow-400 bg-yellow-50 rounded-xl shadow-sm">
    <div class="flex justify-between items-center">
        <strong>⭐ تقييمك</strong>
        <span class="text-yellow-600 font-bold">{{ $userRating->stars }} / 5</span>
    </div>
    <p class="text-gray-800 mt-2">{{ $userRating->comment ?: 'بدون تعليق' }}</p>

    {{-- ✏️ زر تعديل التقييم --}}
    <button onclick="document.getElementById('editRatingModal').classList.remove('hidden')"
            class="mt-3 text-sm text-blue-600 underline">
        ✏️ تعديل التقييم
    </button>
</div>

{{-- 🟡 مودال تعديل التقييم --}}
<div id="editRatingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-lg">
        <h3 class="text-xl font-bold mb-4">تعديل تقييمك</h3>

        <form method="POST" action="{{ route('service.rating.update') }}">
            @csrf

            <input type="hidden" name="id" value="{{ $userRating->id }}">

            <select name="stars" class="w-full mb-3 border p-3 rounded-xl" required>
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}" {{ $userRating->stars == $i ? 'selected' : '' }}>
                        {{ $i }} ⭐
                    </option>
                @endfor
            </select>

            <textarea name="comment" class="w-full border p-3 rounded-xl">{{ $userRating->comment }}</textarea>

            <div class="flex justify-between mt-4">
                <button type="button"
                        onclick="document.getElementById('editRatingModal').classList.add('hidden')"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 py-2 px-4 rounded-xl">
                    إلغاء
                </button>

                <button class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded-xl">
                    💾 حفظ التعديلات
                </button>
            </div>
        </form>
    </div>
</div>
@endif

{{-- ⭐ التقييمات --}}
<h2 class="text-2xl font-bold text-gray-800 mt-12 mb-4">⭐ التقييمات والمراجعات</h2>

@forelse($serviceRatings as $rating)
    <div class="p-4 bg-white border rounded-xl shadow-sm mb-3">
        <div class="flex justify-between items-center">
            <strong>{{ $rating->name }}</strong>
            <span class="text-yellow-500">⭐ {{ $rating->stars }}</span>
        </div>
        <p class="text-gray-600 mt-2">{{ $rating->comment }}</p>
    </div>
@empty
    <p class="text-gray-500">لا توجد تقييمات بعد.</p>
@endforelse


{{-- ✅ إضافة تقييم (فقط إذا لم يقيّم المستخدم من قبل) --}}
@if(!$userRating)
<div class="mt-10 bg-white border rounded-xl p-6 shadow-sm">

    @if(session('success'))
        <div class="mb-3 p-3 bg-green-100 border border-green-300 text-green-700 rounded-xl">
            {{ session('success') }}
        </div>
    @endif

    <h3 class="text-xl font-bold mb-4">أضف تقييمك</h3>

    @guest
        <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-xl text-center">
            <p class="text-gray-700 mb-3">لإضافة تقييم يجب تسجيل الدخول أولاً</p>
            <a href="{{ route('login') }}"
               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-5 rounded-xl text-sm font-semibold">
                🔐 تسجيل الدخول
            </a>
        </div>
    @else
        <form method="POST" action="{{ route('service.rating.store') }}">
            @csrf

            <input type="hidden" name="subcategory" value="{{ $subcategory }}">
            <input type="hidden" name="user_id" value="{{ auth()->id() }}">

            <input type="text" name="name" placeholder="اسمك" value="{{ auth()->user()->name }}"
                   class="w-full mb-3 border p-3 rounded-xl" required>

            <select name="stars" class="w-full mb-3 border p-3 rounded-xl" required>
                <option value="">اختر التقييم</option>
                @for($i=1;$i<=5;$i++)
                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                @endfor
            </select>

            <textarea name="comment" class="w-full border p-3 rounded-xl" placeholder="ملاحظات (اختياري)"></textarea>

            <button class="mt-4 w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-xl">
                ✅ إرسال التقييم
            </button>
        </form>
    @endguest

</div>
@endif


{{-- 🗺️ Map Script --}}
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
let map = L.map('map').setView([34.8021, 38.9968], 7);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

let markers = L.layerGroup().addTo(map);

function refreshMarkers() {
    markers.clearLayers();
    document.querySelectorAll('.service-card').forEach(card => {
        let lat = parseFloat(card.dataset.lat);
        let lng = parseFloat(card.dataset.lng);
        if (!isNaN(lat) && !isNaN(lng)) {
            L.marker([lat, lng]).addTo(markers);
        }
    });
}

// ✅ تحديث الماركرات مباشرة بعد تحميل الصفحة (وأيضاً بعد الفلاتر)
refreshMarkers();

// ✅ إصلاح مشكلة ظهور الخريطة
setTimeout(() => { map.invalidateSize(); }, 400);

// ✅ عند تمرير الماوس على بطاقة — التركيز على موقعها
document.querySelectorAll('.service-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        map.setView([this.dataset.lat, this.dataset.lng], 14);
    });
});
</script>

</x-app-layout>
