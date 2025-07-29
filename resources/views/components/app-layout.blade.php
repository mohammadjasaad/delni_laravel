<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delni.co</title>

    <!-- Tailwind CSS -->
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 text-gray-800">

    <!-- Include الهيدر -->
    @include('partials.header')

    <!-- محتوى الصفحة -->
    <main class="min-h-screen py-8">
        {{ $slot }}
    </main>

    <!-- Include الفوتر -->
    @include('partials.footer')

    <!-- سكربتات جافاسكربت -->
    @vite('resources/js/app.js')
</body>
</html>
