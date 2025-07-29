<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delni - {{ __('Register') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900 antialiased">

    <div class="min-h-screen flex flex-col items-center justify-center">
        <div class="w-full max-w-md p-6 bg-white shadow-md rounded-lg">
            {{ $slot }}
        </div>
    </div>

</body>
</html>
