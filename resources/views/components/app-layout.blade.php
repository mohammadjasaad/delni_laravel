{{-- resources/views/components/app-layout.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Delni.co') }}</title>
    (['resources/css/app.css','resources/js/app.js']){{-- AlpineJS للميزات مثل x-show/x-data --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-50 text-gray-800 {{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">

    {{-- شريط تنبيه أعلى الموقع --}}
    <div class="bg-yellow-100 text-center py-2 text-sm text-yellow-900 font-semibold">
        🚧 هذا الموقع في نسخته التجريبية - نعمل على تطويره وتحسينه يومياً. شكراً لدعمكم ❤️
    </div>

    {{-- فلاش رسائل عامة --}}
    @includeIf('components.flash')

    {{-- الهيدر/الناڤبار (مع توافق قديم) --}}
    (['components.navbar','partials.header','_legacy.header_legacy']){{-- المحتوى --}}
    <main class="min-h-screen py-8">
        {{ $slot }}
    </main>

    {{-- فوتر (إن وجد) --}}
    @includeIf('partials.footer')
</body>
</html>
