<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="rtl">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Delni.co') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- ✅ الهيدر الموحد --}}
    @include('partials.header')

    {{-- ✅ محتوى الصفحة --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
</body>
</html>
