{{-- resources/views/cart/index.blade.php --}}
<x-app-layout title="السلة 🛒">
<div class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 lg:grid-cols-3 gap-8">

    {{-- ✅ قائمة المنتجات --}}
    <div class="lg:col-span-2 space-y-4">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">🛒 سلة المشتريات</h1>

        @forelse($items as $item)
            <div class="flex items-center gap-4 bg-white dark:bg-gray-800 p-4 rounded-xl shadow">
                
                {{-- صورة المنتج --}}
                <img src="{{ asset('storage/' . $item->product->images[0]) }}"
                     class="w-24 h-24 rounded-lg object-cover">

                {{-- تفاصيل المنتج --}}
                <div class="flex-1 space-y-1">
                    <h2 class="font-bold text-gray-900 dark:text-white text-lg">
                        {{ $item->product->name }}
                    </h2>

                    <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                        {{ $item->product->description }}
                    </p>

                    <div class="text-yellow-600 dark:text-yellow-400 text-lg font-bold">
                        💰 {{ number_format($item->product->price) }} ل.س
                    </div>
                </div>

                {{-- تحكم العدد قريباً .. --}}
<div class="flex items-center gap-3">
    <form action="{{ route('cart.decrease', $item->id) }}" method="POST">
        @csrf
        <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded">
            ➖
        </button>
    </form>

    <span class="text-lg font-bold text-gray-800 dark:text-white">
        {{ $item->quantity }}
    </span>

    <form action="{{ route('cart.increase', $item->id) }}" method="POST">
        @csrf
        <button class="px-3 py-1 bg-gray-200 dark:bg-gray-700 rounded">
            ➕
        </button>
    </form>
</div>

                {{-- حذف --}}
                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button class="text-red-600 hover:text-red-800 text-xl">🗑️</button>
                </form>

            </div>
        @empty
            <p class="text-gray-600 dark:text-gray-400 text-lg text-center py-10">السلة فارغة 💔</p>
        @endforelse
    </div>

    {{-- ✅ ملخص السلة --}}
    <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow h-fit sticky top-20">
        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-4">💳 الملخص</h3>

        <div class="space-y-2 text-gray-700 dark:text-gray-300">
            <div class="flex justify-between text-lg">
                <span>المجموع:</span>
                <span>{{ number_format($total) }} ل.س</span>
            </div>

            <hr class="my-2 border-gray-300 dark:border-gray-700">

            <div class="flex justify-between text-lg font-bold text-yellow-600 dark:text-yellow-400">
                <span>الإجمالي النهائي:</span>
                <span>{{ number_format($total) }} ل.س</span>
            </div>
        </div>

        <a href="https://wa.me/?text={{ urlencode('أريد إتمام طلب شراء من السلة.') }}"
           class="block text-center w-full mt-6 py-3 rounded-xl bg-green-500 hover:bg-green-600 text-white text-lg font-semibold shadow">
            ✅ متابعة عبر واتساب
        </a>
    </div>

</div>
</x-app-layout>
