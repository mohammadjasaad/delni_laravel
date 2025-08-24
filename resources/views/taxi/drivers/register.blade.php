<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-extrabold text-center text-gray-800 mb-6">🚖 تسجيل سائق جديد</h1>

        <!-- ✅ رسائل النجاح / الأخطاء -->
        @if(session('success'))
            <div class="mb-4 text-green-600 font-semibold text-center">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 text-red-600 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li class="font-semibold">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('driver.register.submit') }}">
            @csrf

            <!-- الاسم -->
            <div class="mb-4">
                <x-label for="name" value="الاسم الكامل" />
                <x-input id="name" type="text" name="name" class="w-full mt-1" required autofocus />
            </div>

            <!-- البريد الإلكتروني -->
            <div class="mb-4">
                <x-label for="email" value="البريد الإلكتروني" />
                <x-input id="email" type="email" name="email" class="w-full mt-1" required />
            </div>

            <!-- رقم الهاتف -->
            <div class="mb-4">
                <x-label for="phone" value="رقم الهاتف" />
                <x-input id="phone" type="text" name="phone" class="w-full mt-1" required />
            </div>

            <!-- كلمة المرور -->
            <div class="mb-4">
                <x-label for="password" value="كلمة المرور" />
                <x-input id="password" type="password" name="password" class="w-full mt-1" required />
            </div>

            <!-- تأكيد كلمة المرور -->
            <div class="mb-6">
                <x-label for="password_confirmation" value="تأكيد كلمة المرور" />
                <x-input id="password_confirmation" type="password" name="password_confirmation" class="w-full mt-1" required />
            </div>

            <!-- زر التسجيل -->
            <div>
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    🚀 إنشاء الحساب
                </x-button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('driver.login') }}" class="text-sm text-gray-600 hover:underline">
                🔐 لديك حساب؟ تسجيل الدخول من هنا
            </a>
        </div>
    </div>
</x-guest-layout>
