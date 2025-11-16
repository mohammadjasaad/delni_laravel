<x-guest-layout>
    <div class="max-w-md mx-auto bg-white p-8 rounded-2xl shadow-md mt-10">
        <div class="text-center mb-6">
            <img src="/logo.png" class="w-20 mx-auto mb-3">
            <h2 class="text-2xl font-bold">تسجيل الدخول / إنشاء حساب</h2>
            <p class="text-gray-600 text-sm">أدخل رقم هاتفك للمتابعة</p>
        </div>

        {{-- ✅ رسائل نجاح --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-2 rounded mb-2 text-sm">{{ session('success') }}</div>
        @endif

        {{-- ❌ رسائل خطأ --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-2 rounded mb-2 text-sm">{{ $errors->first() }}</div>
        @endif

        <form action="{{ route('send.code') }}" method="POST" class="space-y-4" onsubmit="return mergePhone()">
            @csrf

            <label class="text-sm text-gray-700 block text-right">رقم الهاتف</label>

            <div class="flex">
                {{-- ✅ قائمة كود الدولة --}}
                <select id="country_code" class="border border-gray-300 rounded-l-lg px-3 bg-gray-50 text-sm">
                    <option value="+963">🇸🇾 سوريا (+963)</option>
                    <option value="+90">🇹🇷 تركيا (+90)</option>
                    <option value="+971">🇦🇪 الإمارات (+971)</option>
                    <option value="+966">🇸🇦 السعودية (+966)</option>
                    <option value="+20">🇪🇬 مصر (+20)</option>
                </select>

                {{-- ✅ الرقم الذي سيظهر للمستخدم --}}
                <input type="text" id="phone_input" class="w-full border rounded-r-lg p-3 text-sm"
                       placeholder="مثال: 987654321" required>
            </div>

            {{-- ✅ الرقم النهائي الذي سيُرسل للـ Controller --}}
            <input type="hidden" name="phone" id="phone_full">

            <button type="submit" class="w-full bg-green-600 text-white py-3 rounded-lg text-lg hover:bg-green-700">
                إرسال كود عبر واتساب ✅
            </button>
        </form>
    </div>

    <script>
        function mergePhone() {
            let code = document.getElementById('country_code').value;
            let phone = document.getElementById('phone_input').value.replace(/\s+/g, '');
            document.getElementById('phone_full').value = code + phone;
            return true;
        }
    </script>

</x-guest-layout>
