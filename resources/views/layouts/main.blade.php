<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Delni.co') }}</title>
    (['resources/css/app.css','resources/js/app.js'])</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- ✅ الشريط العلوي --}}
    {{-- ✅ شريط التنقل الموحد --}}
@include('components.navbar')

    {{-- ✅ محتوى الصفحة --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    <footer class="bg-white mt-10 text-center text-gray-600 py-6 text-sm">
        © 2025 Delni.co — جميع الحقوق محفوظة
    </footer>

</body>
</html>
