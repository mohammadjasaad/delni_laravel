<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">

        {{-- ✅ عنوان الصفحة --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('messages.edit_info') }}</h1>

        {{-- ✅ رسالة نجاح --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded mb-6 text-center">
                {{ session('success') }}
            </div>
        @endif

        {{-- ✅ عرض الأخطاء --}}
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded mb-6">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li>⚠️ {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج تعديل البيانات --}}
        <form method="POST" action="{{ route('dashboard.myinfo.update') }}">
            @csrf

            {{-- الاسم --}}
            <div class="mb-4">
                <x-label for="name" :value="__('messages.name')" />
                <x-input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" class="block mt-1 w-full" required />
            </div>

            {{-- البريد الإلكتروني --}}
            <div class="mb-4">
                <x-label for="email" :value="__('messages.email')" />
                <x-input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" class="block mt-1 w-full" required />
            </div>

            {{-- كلمة المرور (اختياري) --}}
            <div class="mb-4">
                <x-label for="password" value="كلمة المرور الجديدة (اختياري)" />
                <x-input id="password" type="password" name="password" class="block mt-1 w-full" />
            </div>

            {{-- تأكيد كلمة المرور --}}
            <div class="mb-6">
                <x-label for="password_confirmation" value="تأكيد كلمة المرور" />
                <x-input id="password_confirmation" type="password" name="password_confirmation" class="block mt-1 w-full" />
            </div>

            {{-- زر الحفظ --}}
            <div class="text-right">
                <x-button class="bg-yellow-500 hover:bg-yellow-600">
                    💾 {{ __('messages.save') }}
                </x-button>
            </div>

        </form>
    </div>
</x-app-layout>
