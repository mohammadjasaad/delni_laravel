<x-app-layout title="تفاصيل الطلب #{{ $order->id }}">
<div class="max-w-5xl mx-auto px-4 py-10">
    
    {{-- العنوان --}}
    <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-6">
        🧾 تفاصيل الطلب رقم #{{ $order->id }}
    </h1>

    {{-- بيانات الطلب الأساسية --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow mb-6">
        <p><strong>الاسم:</strong> {{ $order->name }}</p>
        <p><strong>رقم الهاتف:</strong> {{ $order->phone }}</p>
        <p><strong>العنوان:</strong> {{ $order->address }}</p>
        <p><strong>الحالة:</strong> <span class="text-yellow-600">{{ $order->status }}</span></p>
        <p><strong>المجموع:</strong> 💰 {{ number_format($order->total) }} ل.س</p>
    </div>

    {{-- قائمة المنتجات --}}
    <h2 class="text-xl font-bold text-gray-700 dark:text-white mb-4">🛍️ المنتجات</h2>
    <div class="space-y-4">
        @foreach($order->items as $item)
            <div class="flex items-center bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
                <img src="{{ asset('storage/' . $item->product->images[0]) }}" class="w-20 h-20 object-cover rounded-lg mr-4">

                <div class="flex-1">
                    <h3 class="font-bold text-gray-900 dark:text-white">{{ $item->product->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-400 line-clamp-2">
                        {{ $item->product->description }}
                    </p>
                    <p class="text-yellow-600 dark:text-yellow-400 font-semibold mt-1">
                        {{ $item->quantity }} × {{ number_format($item->price) }} ل.س
                    </p>
                </div>

                <div class="text-lg font-bold text-gray-800 dark:text-white">
                    💰 {{ number_format($item->price * $item->quantity) }} ل.س
                </div>
            </div>
        @endforeach
    </div>

    {{-- إجمالي الطلب --}}
    <div class="bg-gray-100 dark:bg-gray-900 p-4 rounded-xl mt-6 text-right text-lg font-bold text-yellow-600">
        الإجمالي النهائي: {{ number_format($order->total) }} ل.س
    </div>

    {{-- زر الرجوع --}}
    <div class="mt-8 text-center">
        <a href="{{ route('dashboard.myorders') }}"
           class="px-6 py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-lg font-semibold">
            🔙 العودة إلى طلباتي
        </a>
    </div>
</div>
</x-app-layout>
