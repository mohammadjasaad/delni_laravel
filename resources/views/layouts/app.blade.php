<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Delni.co') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">
    
    <!-- Styles -->
    @vite('resources/css/app.css')

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    {{-- ✅ الشريط العلوي للتنبيه --}}
    <div class="bg-yellow-100 text-center py-2 text-sm text-yellow-900 font-semibold">
        🚧 هذا الموقع في نسخته التجريبية - نعمل على تطويره وتحسينه يومياً. شكراً لدعمكم ❤️
    </div>

    {{-- ✅ الشريط العلوي الرئيسي --}}
    @include('components.navbar')

    {{-- ✅ محتوى الصفحة --}}
    <main class="py-8">
        {{ $slot }}
    </main>

</body>
</html>
