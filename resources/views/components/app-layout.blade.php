{{-- resources/views/components/app-layout.blade.php --}}
@props([
    'title' => config('app.name', 'Delni.co'),
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
