<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-6">

        <h1 class="text-2xl font-bold mb-6 text-gray-800">➕ تذكرة دعم جديدة</h1>

        {{-- ✅ رسالة نجاح --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ عرض الأخطاء --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج إنشاء التذكرة --}}
        <form method="POST" action="{{ route('support.store') }}" class="space-y-6">
            @csrf

            {{-- 📝 الموضوع --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">📝 موضوع التذكرة</label>
                <input type="text" name="subject" value="{{ old('subject') }}"
                       class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                       placeholder="مثال: مشكلة في تسجيل الدخول">
            </div>

            {{-- 💬 الرسالة --}}
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">💬 الرسالة</label>
                <textarea name="message" rows="6"
                          class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"
                          placeholder="اشرح مشكلتك بالتفصيل">{{ old('message') }}</textarea>
            </div>

            {{-- ✅ زر الإرسال --}}
            <div>
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded font-semibold">
                    🚀 إرسال التذكرة
                </button>
            </div>
        </form>

        {{-- 🔙 العودة --}}
        <div class="mt-6">
            <a href="{{ route('support.index') }}"
               class="text-sm text-gray-600 hover:underline">⬅️ العودة إلى التذاكر</a>
        </div>
    </div>
</x-app-layout>

