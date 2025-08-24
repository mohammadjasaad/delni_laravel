<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale()==='ar' ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', config('app.name'))</title>
  <!-- اختياري: إن كان لديك CSS في public/css/app.css -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  <style>
    body{font-family:system-ui,-apple-system,Segoe UI,Roboto,Ubuntu,Cantarell,Noto Sans,sans-serif;background:#f8fafc;margin:0}
    .container{max-width:960px;margin:2rem auto;padding:1rem}
    .card{background:#fff;border-radius:12px;box-shadow:0 6px 18px rgba(0,0,0,.06);padding:1.25rem}
    .rtl *{text-align:right}
  </style>
</head>
<body class="{{ app()->getLocale()==='ar' ? 'rtl' : '' }}">
  <div class="container">
    @yield('content')
  </div>
</body>
</html>
