<x-app-layout>
<div class="max-w-7xl mx-auto px-4 py-8">

    <h1 class="text-2xl font-extrabold text-yellow-600 mb-6 flex items-center gap-2">
        <i class="fas fa-tools"></i> {{ $service_type }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

        @forelse($services as $service)
            @php
                $images = is_array($service->images) ? $service->images : json_decode($service->images, true);
                $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');

                $serviceTypes = [
                    'maintenance' => 'صيانة عامة',
                    'cleaning' => 'تنظيف منازل ومكاتب',
                    'moving' => 'نقل أثاث',
                    'gardening' => 'تنسيق حدائق',
                    'pets' => 'رعاية الحيوانات',

                    'car-mechanic' => 'ميكانيك سيارات',
                    'car-electric' => 'كهرباء سيارات',
                    'car-wash' => 'غسيل سيارات',
                    'cargo' => 'نقل بضائع',
                    'driver' => 'سائق خاص',

                    'private-lessons' => 'دروس خصوصية',
                    'programming' => 'كورسات برمجة',
                    'languages' => 'تعليم لغات',
                    'music' => 'تعليم موسيقى',
                    'fitness' => 'تدريب رياضي',

                    'dentists' => 'أطباء أسنان',
                    'clinics' => 'عيادات وصيدليات',
                    'barbers' => 'صالونات حلاقة',
                    'beauty' => 'مراكز تجميل',
                    'massage' => 'مساج وعلاج طبيعي',

                    'lawyers' => 'محاماة',
                    'accounting' => 'محاسبة',
                    'marketing' => 'تسويق رقمي',
                    'design' => 'تصميم وغرافيك',
                    'photography' => 'تصوير ومونتاج',

                    'university' => 'تسجيل جامعي',
                    'translation' => 'ترجمة',
                    'research' => 'كتابة أبحاث',
                    'documents' => 'تخليص معاملات',
                ];

                $serviceLabel = $serviceTypes[$service->service_type] ?? 'خدمة';
            @endphp

            <div class="bg-white rounded-2xl shadow hover:shadow-xl transition overflow-hidden">

                {{-- صورة الخدمة --}}
                <a href="{{ route('ads.show', $service->slug) }}">
                    <img src="{{ $firstImage }}" class="w-full h-48 object-cover" alt="{{ $service->title }}">
                </a>

                <div class="p-4 space-y-2">

                    {{-- العنوان --}}
                    <h3 class="font-bold text-gray-800 text-base truncate">
                        {{ $service->title }}
                    </h3>

                    {{-- نوع الخدمة --}}
                    <p class="text-sm text-yellow-600 font-semibold flex items-center gap-1">
                        <i class="fas fa-tools"></i> {{ $serviceLabel }}
                    </p>

                    {{-- المزود --}}
                    @if($service->provider_name)
                        <p class="text-sm text-gray-600">
                            <i class="fas fa-user-tie text-blue-500"></i> {{ $service->provider_name }}
                        </p>
                    @endif

                    {{-- المدينة --}}
                    <p class="text-sm text-gray-500 flex items-center gap-1">
                        <i class="fas fa-map-marker-alt text-red-500"></i> {{ $service->city }}
                    </p>

                    {{-- السعر --}}
                    <p class="text-red-600 font-bold text-sm">
                        {{ number_format($service->price) }} 
                        {{ $service->currency == 'USD' ? '$' : 'ل.س' }}
                    </p>

                    {{-- زر التفاصيل --}}
                    <a href="{{ route('ads.show', $service->slug) }}"
                       class="block w-full text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 rounded-lg transition">
                        👁️ عرض التفاصيل
                    </a>

                </div>

            </div>
        @empty

            <p class="col-span-4 text-center text-gray-500 py-10">
                لا توجد خدمات متاحة حالياً.
            </p>

        @endforelse

    </div>

    <div class="mt-6">
        {{ $services->links() }}
    </div>

</div>
</x-app-layout>
