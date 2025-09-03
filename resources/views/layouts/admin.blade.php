{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.admin_panel') }} - @yield('title', config('app.name', 'Delni.co'))</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">
    <style> body { font-family: 'Cairo', sans-serif; } </style>
</head>
<body class="bg-gray-100 font-sans antialiased">

    <header class="bg-white shadow py-4 px-6 flex justify-between items-center border-b">
        <div class="text-xl font-bold text-yellow-600">
            🛠️ {{ __('messages.admin_panel') }}
        </div>

        <div class="flex items-center gap-6">
            {{-- 🔔 إشعارات --}}
            @php $unread = auth()->user()->unreadNotifications()->count(); @endphp
            <a href="{{ route('admin.notifications') }}" class="relative text-gray-700 hover:text-yellow-600 text-xl">
                🔔
                @if($unread > 0)
                    <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-1.5">
                        {{ $unread }}
                    </span>
                @endif
            </a>

            {{-- 🏠 الصفحة الرئيسية --}}
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-yellow-600 font-semibold">
                🏠 {{ __('messages.home') }}
            </a>

            {{-- 🚪 تسجيل الخروج --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-600 hover:underline">🚪 {{ __('messages.logout') }}</button>
            </form>
        </div>
    </header>

    <main class="p-6">@yield('content')</main>

    <footer class="bg-white shadow-inner text-center py-4 text-sm text-gray-500 mt-10">
        © {{ date('Y') }} Delni.co - {{ __('messages.admin_panel') }}
    </footer>

</body>
</html>
