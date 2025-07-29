{{-- resources/views/components/layouts/main-layout.blade.php --}}
@props(['title' => config('app.name', 'Delni.co')])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>{{ $title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 font-sans antialiased">

    {{-- ✅ الهيدر --}}
    @include('partials.header')

    {{-- ✅ المحتوى الرئيسي --}}
    <main>
        {{ $slot }}
    </main>

    {{-- ✅ الفوتر --}}
    @include('partials.footer')

</body>
</html>
