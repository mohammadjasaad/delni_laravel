<x-app-layout>
    <div class="max-w-5xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ $ad->title }}</h1>

        {{-- ✅ صور الإعلان --}}
        @if ($ad->images && is_array(json_decode($ad->images, true)))
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                @foreach (json_decode($ad->images, true) as $image)
                    <div class="border rounded overflow-hidden shadow">
                        <img src="{{ asset('storage/' . $image) }}" alt="Ad Image" class="w-full h-48 object-cover">
                    </div>
                @endforeach
            </div>
        @endif

        {{-- ✅ تفاصيل الإعلان --}}
        <div class="bg-white p-6 rounded shadow space-y-4">
            <p><strong>{{ __('messages.description') }}:</strong> {{ $ad->description }}</p>
            <p><strong>{{ __('messages.price') }}:</strong> {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
            <p><strong>{{ __('messages.city') }}:</strong> {{ $ad->city }}</p>
            <p><strong>{{ __('messages.category') }}:</strong> {{ $ad->category }}</p>
            <p><strong>{{ __('messages.posted_at') }}:</strong> {{ $ad->created_at->format('Y-m-d H:i') }}</p>
        </div>

        {{-- ✅ أزرار التحكم --}}
        <div class="mt-6 flex flex-wrap gap-4">

            <!-- ✏️ تعديل الإعلان -->
            <a href="{{ route('dashboard.ads.edit', $ad->id) }}"
               class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                ✏️ {{ __('messages.edit_ad') }}
            </a>

            <!-- 🔙 رجوع -->
            <a href="{{ route('dashboard.ads') }}"
               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded">
                {{ __('messages.back_to_ads') }}
            </a>

            <!-- 📋 زر نسخ رابط الإعلان -->
            <button onclick="copyToClipboard('{{ route('ads.show', $ad->id) }}')"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-800 px-4 py-2 rounded">
                📋 {{ __('messages.copy_link') }}
            </button>

            <!-- 📲 زر واتساب -->
            <a href="https://wa.me/?text={{ urlencode('👋 مرحبًا، شاهد هذا الإعلان: ' . $ad->title . ' - ' . route('ads.show', $ad->id)) }}"
               target="_blank"
               class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">
                📲 {{ __('messages.contact_on_whatsapp') }}
            </a>
        </div>
    </div>

    {{-- ✅ سكربت النسخ --}}
    <script>
        function copyToClipboard(text) {
            navigator.clipboard.writeText(text).then(function () {
                alert("✅ تم نسخ رابط الإعلان إلى الحافظة!");
            }, function () {
                alert("❌ فشل في نسخ الرابط.");
            });
        }
    </script>
</x-app-layout>
