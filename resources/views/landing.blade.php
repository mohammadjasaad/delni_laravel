<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delni.co - قريبًا</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-yellow-100 flex items-center justify-center min-h-screen font-sans">

    <div class="text-center p-8 bg-white shadow-lg rounded-2xl max-w-xl w-full">
        {{-- الشعار --}}
        <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="mx-auto h-24 mb-6">

        {{-- العنوان --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-2">منصّة Delni.co</h1>

        {{-- الوصف --}}
        <p class="text-gray-600 text-lg mb-6">قريبًا... وجهتك الأولى لبيع وشراء العقارات والسيارات في سوريا</p>

        {{-- زر واتساب --}}
        <a href="https://wa.me/963988779548" target="_blank"
           class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-6 rounded">
            تواصل عبر واتساب
        </a>
    </div>

</body>
</html>
