<x-app-layout title="إتمام الطلب ✅">
<div class="max-w-3xl mx-auto px-4 py-10">

    <h1 class="text-2xl font-bold mb-6">🛍️ إتمام الطلب</h1>

    <form action="{{ route('checkout.store') }}" method="POST" class="space-y-4 bg-white dark:bg-gray-800 p-6 rounded-xl shadow">
        @csrf

        <div>
            <label class="block font-semibold mb-1">الاسم</label>
            <input type="text" name="name" class="w-full rounded-lg bg-gray-100 dark:bg-gray-700" required>
        </div>

        <div>
            <label class="block font-semibold mb-1">رقم الهاتف</label>
            <input type="text" name="phone" class="w-full rounded-lg bg-gray-100 dark:bg-gray-700" required>
        </div>

        <div>
            <label class="block font-semibold mb-1">العنوان</label>
            <textarea name="address" class="w-full rounded-lg bg-gray-100 dark:bg-gray-700" rows="3" required></textarea>
        </div>

        <input type="hidden" name="total" value="{{ $total }}">

        <div class="text-xl font-bold text-yellow-600 dark:text-yellow-400">
            المجموع النهائي: {{ number_format($total) }} ل.س
        </div>

        <button class="w-full py-3 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl text-lg">
            ✅ تأكيد الطلب
        </button>
    </form>

</div>
</x-app-layout>
