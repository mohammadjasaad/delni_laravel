<!-- resources/views/welcome.blade.php -->
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>Delni.co - دليلك في العقارات والسيارات وخدمات التاكسي</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-yellow-50 text-gray-800 font-sans">

    <div class="min-h-screen flex flex-col justify-center items-center text-center px-4">
        <img src="/images/logo-delni.png" alt="Delni Logo" class="w-32 mb-6">
        <h1 class="text-4xl font-bold text-yellow-600 mb-2">مرحباً بك في Delni.co 👋</h1>
        <p class="text-lg mb-6 text-gray-700">
            منصتك الأولى للإعلانات العقارية والسيارات <br> وخدمة Delni Taxi الذكية 🚕
        </p>

        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <a href="{{ route('ads.index') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-3 rounded-lg shadow">
                🚗 تصفح الإعلانات
            </a>
            <a href="{{ route('taxi.home') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg shadow">
                🚖 اطلب سيارة Delni Taxi
            </a>
        </div>

        <div class="mt-4 text-sm text-gray-600">
            هل أنت سائق؟ <a href="{{ route('driver.login') }}" class="text-blue-600 underline">دخول السائق</a>
        </div>

        <p class="mt-10 text-gray-500 text-xs">© 2025 جميع الحقوق محفوظة لـ Delni.co</p>
        <p class="text-gray-400 text-sm mt-1">للتواصل: <a href="https://wa.me/963988779548" class="underline">+963 988 779 548</a></p>
    </div>

</body>
</html>
