{{-- components/main-layout.blade.php --}}
@props(['title' => config('app.name')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">
<div class="bg-yellow-100 text-yellow-900 text-center py-2 text-sm">
    🚧 هذا الموقع في نسخته التجريبية - نعمل على تطويره وتحسينه يوميًا. شكرًا لدعمكم 
</div>

    {{-- ✅ الهيدر --}}
    @include('layouts.partials.header')

    {{-- ✅ المحتوى --}}
    <main class="min-h-screen">
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    @include('layouts.partials.footer')

</body>
</html>
