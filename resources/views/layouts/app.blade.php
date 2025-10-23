<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Delni.co')</title>

    <!-- ✅ خط Cairo -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">
    <!-- ✅ ستايلات -->
    @vite(['resources/css/app.css'])
    <!-- ✅ FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- ✅ AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

    {{-- ✅ الهيدر الموحد --}}
    @include('partials.header')

    {{-- ✅ Toast Notifications (Stacked & Multiple Messages) --}}
    <div class="fixed top-6 right-6 z-50 space-y-3 w-full max-w-sm" x-data x-cloak>
        @foreach (['success', 'error', 'warning', 'info'] as $msg)
            @if(session($msg))
                @php
                    $messages = is_array(session($msg)) ? session($msg) : [session($msg)];
                @endphp
                @foreach($messages as $message)
                    <div x-data="{ show: true }"
                         x-show="show"
                         x-transition:enter="transform ease-out duration-300 transition"
                         x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
                         x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
                         x-transition:leave="transition ease-in duration-300"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         x-init="setTimeout(() => show = false, 6000)"
                         class="flex justify-between items-center px-4 py-3 rounded-lg shadow-lg
                                @if($msg === 'success') bg-green-100 border border-green-300 text-green-800
                                @elseif($msg === 'error') bg-red-100 border border-red-300 text-red-800
                                @elseif($msg === 'warning') bg-yellow-100 border border-yellow-300 text-yellow-800
                                @elseif($msg === 'info') bg-blue-100 border border-blue-300 text-blue-800
                                @endif">
                        
                        {{-- ✅ أيقونة حسب نوع الرسالة --}}
                        <span class="flex items-center gap-2">
                            @if($msg === 'success') <i class="fas fa-check-circle"></i>
                            @elseif($msg === 'error') <i class="fas fa-exclamation-triangle"></i>
                            @elseif($msg === 'warning') <i class="fas fa-bolt"></i>
                            @elseif($msg === 'info') <i class="fas fa-info-circle"></i>
                            @endif
                            {{ $message }}
                        </span>

                        {{-- ❌ زر إغلاق --}}
                        <button @click="show = false" class="ml-4 font-bold
                                @if($msg === 'success') text-green-700 hover:text-green-900
                                @elseif($msg === 'error') text-red-700 hover:text-red-900
                                @elseif($msg === 'warning') text-yellow-700 hover:text-yellow-900
                                @elseif($msg === 'info') text-blue-700 hover:text-blue-900
                                @endif">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                @endforeach
            @endif
        @endforeach
    </div>

    {{-- ✅ محتوى الصفحة --}}
    <main class="flex-1 py-8">
        @isset($slot) {{ $slot }} @endisset
        @yield('content')
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')

    {{-- ✅ ملف JS --}}
    @vite(['resources/js/app.js'])

    {{-- ✅ سكربت Dark Mode --}}
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            function toggleDarkMode() {
                document.documentElement.classList.toggle('dark');
                localStorage.setItem('darkMode',
                    document.documentElement.classList.contains('dark') ? 'enabled' : 'disabled'
                );
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
