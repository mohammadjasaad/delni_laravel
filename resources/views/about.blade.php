{{-- resources/views/about.blade.php --}}
<x-main-layout>
    <div class="max-w-4xl mx-auto py-10 px-4 text-gray-800">

        <h1 class="text-3xl font-bold mb-6 text-center text-yellow-500">
            {{ __('messages.about_us') }}
        </h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-4 leading-relaxed">
            <p>
                منصة <strong>دلني Delni.co</strong> هي وجهتك الأولى للإعلانات المبوبة في سوريا، نقدم لك طريقة سهلة وموثوقة لنشر وبيع العقارات والسيارات بكل احترافية.
            </p>

            <p>
                مهمتنا هي ربط البائعين بالمشترين من خلال واجهة بسيطة وسريعة، دون وسطاء، وبأقصى درجات الأمان والراحة.
            </p>

            <p>
                يمكنك تصفح آلاف الإعلانات، أو نشر إعلانك الخاص خلال دقائق فقط.
            </p>

            <p>
                دلني هو مشروع مستقل تم تطويره بخبرة وشغف لتقديم تجربة رقمية فريدة لكل السوريين في الداخل والخارج.
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="{{ route('ads.index') }}" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded">
                {{ __('messages.browse_ads') }}
            </a>
        </div>

    </div>
</x-main-layout>
