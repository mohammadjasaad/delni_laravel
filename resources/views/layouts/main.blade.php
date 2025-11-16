<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- ✅ تعريف تطبيق فيسبوك لإزالة التحذير -->
    <meta property="fb:app_id" content="1584714839078603" />

    <!-- ✅ Facebook Domain Verification -->

    <!-- ✅ Open Graph -->
    <meta property="og:title" content="Delni.co">
    <meta property="og:description" content="Delni.co هي منصتك للإعلانات المبوبة في سوريا — بيع واشتري العقارات والسيارات والخدمات بسهولة وسرعة.">
    <meta property="og:image" content="https://delni.co/images/delnilogo.png">
    <meta property="og:url" content="https://delni.co/">
    <meta property="og:type" content="website">

    <!-- ✅ Lightbox يجب أن يكون هنا -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">

    <title>{{ config('app.name', 'Delni.co') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- ✅ الهيدر الموحد --}}
    @include('partials.header')

    {{-- ✅ محتوى الصفحة --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</body>
</html>
