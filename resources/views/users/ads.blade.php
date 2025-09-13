<x-app-layout>
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">
        🧑 {{ $user->name }} - {{ __('messages.ads') }}
    </h1>

    {{-- 🖼️ بطاقة المعلن --}}
    <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 mb-8">
<img src="{{ $user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-user.png') }}" 
     alt="avatar" class="w-12 h-12 rounded-full object-cover border">
        <div>
            <h2 class="font-bold text-lg">{{ $user->name }}</h2>
            <p class="text-gray-600"><i class="fas fa-phone text-green-500"></i> {{ $user->phone ?? 'غير متوفر' }}</p>
            <p class="text-sm text-gray-500">📢 {{ $user->ads()->count() }} {{ __('messages.ads') }}</p>
        </div>
    </div>

    {{-- 📝 إعلانات المستخدم --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @forelse($ads as $ad)
            @php
                $imgs = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                $img  = !empty($imgs[0]) ? asset('storage/'.$imgs[0]) : asset('storage/placeholder.png');
            @endphp
            <a href="{{ route('ads.show', $ad->id) }}" class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                <img src="{{ $img }}" class="w-full h-40 object-cover" alt="ad">
                <div class="p-3">
                    <h3 class="font-bold truncate">{{ $ad->title }}</h3>
                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt"></i> {{ $ad->city }}</p>
                    <p class="text-red-600 font-bold text-sm"><i class="fas fa-dollar-sign"></i> {{ number_format($ad->price) }} {{ __('messages.currency') }}</p>
                </div>
            </a>
        @empty
            <p class="text-gray-500">🚫 {{ __('messages.no_ads_found') }}</p>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $ads->links() }}
    </div>
</div>
</x-app-layout>
