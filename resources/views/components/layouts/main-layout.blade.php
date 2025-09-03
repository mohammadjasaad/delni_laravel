{{-- resources/views/components/layouts/main-layout.blade.php --}}
@props(['title' => config('app.name', 'Delni.co')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>

    {{-- ✅ ملفات ستايل وجافاسكربت --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- ✅ إضافة AlpineJS --}}
    <script src="//unpkg.com/alpinejs" defer></script>

    {{-- ✅ الخط العربي Cairo --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- ✅ الهيدر الموحد --}}
    @include('partials.header')

    {{-- ✅ المحتوى الرئيسي --}}
    <main class="py-8">
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')

</body>
</html>
