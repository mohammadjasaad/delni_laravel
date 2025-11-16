{{-- resources/views/components/app-layout.blade.php --}}
@props([
    'title' => config('app.name', 'Delni.co'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ✅ Facebook Domain Verification -->
<meta name="facebook-domain-verification" content="htc7zaxssdfu9svapezkx5h4mtp9wd" />
    <!-- ✅ Facebook App ID -->
    <meta property="fb:app_id" content="1584714839078603" />

    <!-- ✅ Open Graph Tags (تظهر عند مشاركة الرابط) -->
    <meta property="og:title" content="Delni.co - الإعلانات المبوبة في سوريا">
    <meta property="og:description" content="Delni.co هي منصتك للإعلانات المبوبة في سوريا — بيع واشتري العقارات والسيارات والخدمات بسهولة.">
    <meta property="og:image" content="https://delni.co/images/delnilogo.png">
    <meta property="og:image:alt" content="Delni Logo">
    <meta property="og:url" content="https://delni.co/">
    <meta property="og:type" content="website">

    <title>{{ $title }}</title>

    {{-- ✅ ملفات CSS و JS --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ إضافة AlpineJS --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- ✅ خط Cairo --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">
    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-100 text-gray-800 antialiased">

    {{-- ✅ الهيدر الموحد --}}
    @include('partials.header')

    {{-- ✅ محتوى الصفحة --}}
    <main class="py-6">
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')

    {{-- ✅ Toast Component --}}
    <x-toast />
</body>
</html>
