<x-guest-layout>
    <div class="max-w-md mx-auto mt-12 bg-white p-8 rounded-xl shadow-lg">
        <h1 class="text-2xl font-extrabold text-center text-gray-800 mb-6">🚖 دخول السائق</h1>

        <!-- ✅ رسائل -->
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

        <form method="POST" action="{{ route('driver.login.submit') }}">
            @csrf

            <!-- البريد الإلكتروني -->
            <div class="mb-4">
                <x-label for="email" value="البريد الإلكتروني" />
                <x-input id="email" type="email" name="email" class="w-full mt-1" required autofocus />
            </div>

            <!-- كلمة المرور -->
            <div class="mb-6">
                <x-label for="password" value="كلمة المرور" />
                <x-input id="password" type="password" name="password" class="w-full mt-1" required />
            </div>

            <!-- زر الدخول -->
            <div>
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    ✅ تسجيل الدخول
                </x-button>
            </div>
        </form>

        <div class="text-center mt-6">
            <a href="{{ route('driver.register') }}" class="text-sm text-gray-600 hover:underline">
                📝 لا تملك حساب؟ سجل كسائق جديد
            </a>
        </div>
    </div>
</x-guest-layout>
