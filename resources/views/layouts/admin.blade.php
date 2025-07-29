{{-- layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>لوحة تحكم المشرف - @yield('title')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 font-sans">

    {{-- ✅ الهيدر --}}
    <header class="bg-white shadow py-4 px-6 flex justify-between items-center border-b">
        <div class="text-xl font-bold text-yellow-600">
            🛠️ لوحة المشرف
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
            <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-yellow-600 font-semibold">🏠 الموقع</a>

            {{-- 🚪 تسجيل الخروج --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="text-sm text-red-600 hover:underline">🚪 خروج</button>
            </form>
        </div>
    </header>

    {{-- ✅ محتوى الصفحة --}}
    <main class="p-6">
        @yield('content')
    </main>

</body>
</html>
