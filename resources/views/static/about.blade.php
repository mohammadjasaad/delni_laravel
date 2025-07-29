@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">من نحن</h1>

    <div class="bg-white p-6 rounded-lg shadow-md text-gray-700 leading-relaxed space-y-4">
        <p>
            منصة <span class="font-semibold text-yellow-600">Delni.co</span> هي وجهتك الأولى لنشر الإعلانات المبوبة الخاصة بـ <span class="font-semibold">العقارات</span> و <span class="font-semibold">السيارات</span> في سوريا.
        </p>

        <p>
                                                بالاضافة لخدمة التكسي و خدمة الطوارئ
            نعمل على تقديم تجربة استخدام سهلة وسريعة تتيح للمستخدمين عرض وشراء العقارات والسيارات بطريقة موثوقة وآمنة. هدفنا هو ربط البائع بالمشتري بدون وسطاء، وبتكلفة صفرية.
        </p>

        <p>
            تأسست Delni.co لتكون منصة محلية شاملة، بتصميم عصري وواجهة عربية بالكامل، مع دعم للغة الإنجليزية لاحقًا.
        </p>

        <p>
            نحن ملتزمون بتطوير المنصة باستمرار لتلبية حاجات المستخدمين وتقديم أفضل خدمة ممكنة.
        </p>

        <p class="text-center text-sm text-gray-400 mt-6">
            جميع الحقوق محفوظة © {{ date('Y') }} Delni.co
        </p>
    </div>
</div>
@endsection
