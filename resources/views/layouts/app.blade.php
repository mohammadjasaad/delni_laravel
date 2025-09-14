<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<!-- ✅ Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<head>
    <meta charset="utf-8">
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
    const toggleBtn = document.getElementById("toggleDarkMode");
    const htmlTag = document.documentElement;

    // ✅ استرجاع الوضع من LocalStorage
    if (localStorage.getItem("theme") === "dark") {
        htmlTag.classList.add("dark");
    }

    if (toggleBtn) {
        toggleBtn.addEventListener("click", () => {
            htmlTag.classList.toggle("dark");
            if (htmlTag.classList.contains("dark")) {
                localStorage.setItem("theme", "dark");
            } else {
                localStorage.setItem("theme", "light");
            }
        });
    }
});
</script>
</body>
</html>
