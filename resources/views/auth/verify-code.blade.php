<x-guest-layout>
    <div class="max-w-md mx-auto mt-16 p-6 bg-white shadow-lg rounded-xl border border-gray-200">
        <h2 class="text-2xl font-bold text-center mb-6">أدخل كود التحقق</h2>

        <form action="{{ route('login.verifyCode') }}" method="POST">
            @csrf

            <input type="hidden" name="phone" value="{{ $phone }}">

            <input type="text" name="whatsapp_code"
                   class="w-full p-3 border rounded-lg focus:ring-yellow-500"
                   placeholder="أدخل الكود" required>

            <button class="mt-4 w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-bold">
                تأكيد الدخول
            </button>
        </form>
    </div>
</x-guest-layout>
