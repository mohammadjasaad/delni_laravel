<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Delni.co - تسجيل الدخول</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-900 text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center">

        <!-- 🟡 شعار Delni.co -->
        <div class="flex justify-center mb-6">
            <a href="/">
                <img src="{{ asset('images/delnilogo.png') }}" 
                     alt="Delni.co"
                     class="w-28 h-28 rounded-full shadow-2xl border-4 border-yellow-400 bg-white p-1 hover:scale-105 transition-all duration-300">
            </a>
        </div>

        <!-- 🧱 صندوق تسجيل -->
        <div class="w-full max-w-md px-6 py-6 bg-white shadow-2xl rounded-2xl border-t-4 border-yellow-400">
            {{ $slot }}
        </div>

        <!-- 🦶 فوتر -->
        <p class="mt-6 text-sm text-gray-400">
            © {{ date('Y') }} <span class="text-yellow-400 font-semibold">Delni.co</span> — جميع الحقوق محفوظة
        </p>
    </div>
</body>
</html>
