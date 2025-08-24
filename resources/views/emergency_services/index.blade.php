<!doctype html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="utf-8">
  <title>مراكز الطوارئ</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>body{font-family:ui-sans-serif,system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif;padding:20px}</style>
</head>
<body>
  <h1>مراكز الطوارئ</h1>
  @if(isset($services) && count($services))
    <ul>
      @foreach($services as $s)
        <li>{{ $s->name ?? '—' }} — {{ $s->city ?? '' }} {{ !empty($s->phone) ? ' | '.$s->phone : '' }}</li>
      @endforeach
    </ul>
  @else
    <p>لا توجد مراكز مسجّلة حاليًا.</p>
  @endif
</body>
</html>
