@props(['title' => config('app.name', 'Delni.co')])
<!doctype html>
<html lang="{{ str_replace('_','-',app()->getLocale()) }}" dir="{{ app()->getLocale()==='ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>{{ $title }}</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 antialiased">
  @includeFirst(['components.navbar','partials.header','_legacy.header_legacy'])
  <main class="max-w-7xl mx-auto p-4">
    {{ $slot }}
  </main>
  @includeIf('partials.footer')
</body>
</html>
