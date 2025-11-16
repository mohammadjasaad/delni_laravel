<x-guest-layout>
    <div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-md mt-10">
        <h2 class="text-xl font-bold text-center mb-4">أدخل الكود</h2>

        <form action="{{ route('verify.code') }}" method="POST" class="space-y-4">
            @csrf

            <input type="hidden" name="phone" value="{{ $phone }}">

            <input type="text" name="code" class="w-full border rounded-lg p-3 text-center text-xl" placeholder="____">

            <button class="w-full bg-yellow-600 text-white py-3 rounded-lg text-lg hover:bg-yellow-700">
                تأكيد الدخول ✅
            </button>
        </form>
    </div>
</x-guest-layout>
