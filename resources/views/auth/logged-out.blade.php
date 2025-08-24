<x-app-layout>
    <div class="max-w-xl mx-auto px-4 py-16 text-center" dir="rtl">
        <h1 class="text-2xl font-bold text-gray-800 mb-3">✅ تم تسجيل الخروج بنجاح</h1>
        <p class="text-gray-600 mb-6">نتمنى لك يوماً سعيداً. يمكنك العودة للصفحة الرئيسية أو تسجيل الدخول مرة أخرى.</p>

        <div class="flex justify-center gap-3">
            <a href="{{ route('home') }}" class="px-5 py-2 rounded bg-gray-100 text-gray-800">الصفحة الرئيسية</a>
            <a href="{{ route('login') }}" class="px-5 py-2 rounded bg-yellow-500 text-white">تسجيل الدخول</a>
        </div>
    </div>
</x-app-layout>
