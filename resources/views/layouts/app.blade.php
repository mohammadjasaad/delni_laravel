<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<!-- ✅ Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<head>
    <meta charset="utf-8">
    <!-- ✅ CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Delni.co')</title>

    <!-- ✅ خط Cairo -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">

    <!-- ✅ ستايلات -->
    @vite(['resources/css/app.css'])

    <!-- ✅ إضافة AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

    {{-- ✅ الهيدر الموحد --}}
    @include('partials.header')

    {{-- ✅ محتوى الصفحة --}}
    <main class="flex-1 py-8">
        @isset($slot)
            {{ $slot }}
        @endisset

        @yield('content')
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')

    {{-- ✅ ملف JS --}}
    @vite(['resources/js/app.js'])
    <!-- ✅ Lightbox2 JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('darkMode', document.documentElement.classList.contains('dark') ? 'enabled' : 'disabled');
            updateIcons();
        }

        function updateIcons() {
            const isDark = document.documentElement.classList.contains('dark');
            const desktopBtn = document.getElementById("toggleDarkModeDesktop");
            const mobileBtn = document.getElementById("toggleDarkModeMobile");
            if (desktopBtn) desktopBtn.textContent = isDark ? "☀️" : "🌙";
            if (mobileBtn) mobileBtn.textContent = isDark ? "☀️" : "🌙";
        }

        const desktopBtn = document.getElementById("toggleDarkModeDesktop");
        const mobileBtn = document.getElementById("toggleDarkModeMobile");

        if (desktopBtn) desktopBtn.addEventListener("click", toggleDarkMode);
        if (mobileBtn) mobileBtn.addEventListener("click", toggleDarkMode);

        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark');
        }
        updateIcons();
    });
    </script>
</body>
</html>
