<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') - {{ config('app.name', 'Delni.co') }}</title>

    @vite(['resources/css/app.css'])
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="text-center max-w-md">
        <div class="mb-6">
            <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="w-20 h-20 mx-auto">
        </div>

        <h1 class="text-6xl font-bold text-yellow-600 mb-4">@yield('code')</h1>
        <p class="text-lg text-gray-700 mb-6">@yield('message')</p>

        <a href="{{ route('ads.index') }}"
           class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded shadow">
            ⬅️ {{ __('messages.back_to_ads') }}
        </a>
    </div>

</body>
</html>
