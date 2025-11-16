{{-- resources/views/auth/unified-login.blade.php --}}
<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-b from-gray-50 to-gray-100 px-4">
        <div class="bg-white shadow-2xl rounded-3xl w-full max-w-lg overflow-hidden border border-gray-200">

            {{-- 🔶 العنوان والشعار --}}
            <div class="text-center py-8 border-b bg-yellow-400">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni" class="mx-auto w-24 h-24 mb-2 rounded-full bg-white p-2 shadow">
                <h1 class="text-3xl font-extrabold text-gray-800">مرحبًا بك في Delni.co</h1>
                <p class="text-gray-700 text-sm mt-1">اختر طريقة تسجيل الدخول</p>
            </div>

            {{-- 🧭 تبويبات الاختيار --}}
            <div class="flex">
                <button id="tabEmail" class="flex-1 py-3 text-lg font-semibold bg-yellow-400 text-black border-r border-gray-200 focus:outline-none transition">📧 البريد الإلكتروني</button>
                <button id="tabPhone" class="flex-1 py-3 text-lg font-semibold bg-gray-100 text-gray-700 focus:outline-none transition hover:bg-yellow-50">📱 الهاتف / واتساب</button>
            </div>

            <div class="p-8">

                {{-- ✅ نموذج البريد الإلكتروني --}}
                <form id="formEmail" method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- البريد الإلكتروني --}}
                    <div class="text-right">
                        <x-label for="email" value="البريد الإلكتروني" class="text-sm font-semibold text-gray-700" />
                        <x-input id="email" type="email" name="email" required autofocus
                                 class="mt-1 w-full text-right border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500"
                                 placeholder="example@email.com" />
                    </div>

                    {{-- كلمة المرور --}}
                    <div class="text-right">
                        <x-label for="password" value="كلمة المرور" class="text-sm font-semibold text-gray-700" />
                        <x-input id="password" type="password" name="password" required
                                 class="mt-1 w-full text-right border-gray-300 rounded-xl focus:ring-yellow-500 focus:border-yellow-500"
                                 placeholder="••••••••" />
                    </div>

                    {{-- تذكرني + نسيت كلمة المرور --}}
                    <div class="flex justify-between items-center text-sm text-gray-600">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="remember" class="rounded text-yellow-500 focus:ring-yellow-500">
                            تذكرني
                        </label>
                        <a href="{{ route('password.request') }}" class="text-yellow-600 hover:underline">نسيت كلمة المرور؟</a>
                    </div>

                    {{-- زر الدخول --}}
                    <button type="submit" class="w-full bg-yellow-400 hover:bg-yellow-500 text-black font-bold py-3 rounded-xl shadow-md">
                        تسجيل الدخول
                    </button>
                </form>

                {{-- ✅ نموذج الهاتف / واتساب --}}
                <form id="formPhone" method="POST" action="{{ route('send.code') }}" onsubmit="return mergePhone()" class="space-y-5 hidden">
                    @csrf

                    <div class="text-right">
                        <x-label for="phone_input" value="رقم الهاتف" class="text-sm font-semibold text-gray-700" />
                        <div class="flex mt-1">
                            <select id="country_code" class="border border-gray-300 rounded-l-xl px-3 bg-gray-50 text-sm">
                                <option value="+963">🇸🇾 سوريا (+963)</option>
                                <option value="+90">🇹🇷 تركيا (+90)</option>
                                <option value="+971">🇦🇪 الإمارات (+971)</option>
                                <option value="+966">🇸🇦 السعودية (+966)</option>
                                <option value="+20">🇪🇬 مصر (+20)</option>
                            </select>
                            <input id="phone_input" type="text" class="w-full border border-l-0 border-gray-300 rounded-r-xl p-3 text-right text-sm focus:ring-yellow-500 focus:border-yellow-500"
                                   placeholder="987654321" required>
                        </div>
                    </div>

                    <input type="hidden" name="phone" id="phone_full">

                    <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-md flex items-center justify-center gap-2">
                        💬 إرسال كود عبر واتساب
                    </button>
                </form>

                {{-- ✅ تسجيل جديد --}}
                <div class="text-center mt-8 text-sm text-gray-600">
                    لا تملك حسابًا؟
                    <a href="{{ route('register') }}" class="text-yellow-600 font-bold hover:underline">أنشئ حسابًا جديدًا</a>
                </div>

            </div>
        </div>
    </div>

    {{-- 🎛️ سكربتات التبديل بين النماذج --}}
    <script>
        const tabEmail = document.getElementById('tabEmail');
        const tabPhone = document.getElementById('tabPhone');
        const formEmail = document.getElementById('formEmail');
        const formPhone = document.getElementById('formPhone');

        tabEmail.addEventListener('click', () => {
            formEmail.classList.remove('hidden');
            formPhone.classList.add('hidden');
            tabEmail.classList.add('bg-yellow-400', 'text-black');
            tabPhone.classList.remove('bg-yellow-400', 'text-black');
            tabPhone.classList.add('bg-gray-100', 'text-gray-700');
        });

        tabPhone.addEventListener('click', () => {
            formPhone.classList.remove('hidden');
            formEmail.classList.add('hidden');
            tabPhone.classList.add('bg-yellow-400', 'text-black');
            tabEmail.classList.remove('bg-yellow-400', 'text-black');
            tabEmail.classList.add('bg-gray-100', 'text-gray-700');
        });

        function mergePhone() {
            const code = document.getElementById('country_code').value;
            const phone = document.getElementById('phone_input').value.replace(/\s+/g, '');
            document.getElementById('phone_full').value = code + phone;
            return true;
        }
    </script>
</x-guest-layout>
