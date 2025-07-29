<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-8">📊 إحصائيات تذاكر الدعم الفني</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
            {{-- 🔢 إجمالي التذاكر --}}
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-sm text-gray-500 mb-2">📦 إجمالي التذاكر</h2>
                <div class="text-3xl font-bold text-gray-800">{{ $total }}</div>
            </div>

            {{-- 🆕 جديد --}}
            <div class="bg-blue-100 shadow rounded-lg p-6 text-center">
                <h2 class="text-sm text-gray-700 mb-2">🆕 جديد</h2>
                <div class="text-2xl font-bold text-blue-800">{{ $new }}</div>
            </div>

            {{-- 🔄 قيد المعالجة --}}
            <div class="bg-yellow-100 shadow rounded-lg p-6 text-center">
                <h2 class="text-sm text-gray-700 mb-2">🔄 قيد المعالجة</h2>
                <div class="text-2xl font-bold text-yellow-700">{{ $processing }}</div>
            </div>

            {{-- ✅ تم الرد --}}
            <div class="bg-green-100 shadow rounded-lg p-6 text-center">
                <h2 class="text-sm text-gray-700 mb-2">✅ تم الرد</h2>
                <div class="text-2xl font-bold text-green-700">{{ $answered }}</div>
            </div>

            {{-- ❌ مغلق --}}
            <div class="bg-gray-200 shadow rounded-lg p-6 text-center">
                <h2 class="text-sm text-gray-700 mb-2">❌ مغلق</h2>
                <div class="text-2xl font-bold text-gray-800">{{ $closed }}</div>
            </div>
        </div>

        <div class="mt-10">
            <a href="{{ route('admin.support_tickets.index') }}"
               class="text-sm text-gray-600 hover:underline">⬅️ العودة إلى إدارة التذاكر</a>
        </div>
    </div>
</x-app-layout>

