<x-app-layout title="تم تأكيد الطلب ✅">
<div class="max-w-xl mx-auto px-4 py-16 text-center">
    <div class="text-6xl mb-6">🎉</div>
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">
        تم تأكيد طلبك بنجاح!
    </h1>
    <p class="text-lg text-gray-600 dark:text-gray-300 mb-8">
        رقم الطلب: <strong>#{{ $order->id }}</strong><br>
        الحالة الحالية: <span class="text-yellow-600">{{ $order->status }}</span>
    </p>
    <a href="{{ route('dashboard.myorders') }}"
       class="inline-block px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-lg font-semibold">
        📦 عرض طلباتي
    </a>
</div>
</x-app-layout>
