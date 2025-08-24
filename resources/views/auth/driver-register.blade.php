<x-guest-layout>
    <div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-xl shadow">
        <h1 class="text-2xl font-bold text-center mb-6">🚖 تسجيل حساب سائق</h1>

        <form method="POST" action="{{ route('driver.register.submit') }}">
            @csrf

            <!-- الاسم -->
            <div class="mb-4">
                <x-label for="name" value="الاسم الكامل" />
                <x-input id="name" class="block mt-1 w-full" type="text" name="name" required autofocus />
            </div>

            <!-- البريد -->
            <div class="mb-4">
                <x-label for="email" value="البريد الإلكتروني" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            </div>

            <!-- رقم الهاتف -->
            <div class="mb-4">
                <x-label for="phone" value="رقم الهاتف" />
                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" required />
            </div>

            <!-- كلمة المرور -->
            <div class="mb-4">
                <x-label for="password" value="كلمة المرور" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>

            <!-- تأكيد كلمة المرور -->
            <div class="mb-6">
                <x-label for="password_confirmation" value="تأكيد كلمة المرور" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            </div>

            <div class="flex items-center justify-center">
                <x-button class="w-full justify-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                    إنشاء حساب سائق
                </x-button>
            </div>
        </form>
    </div>
</x-guest-layout>
