{{-- resources/views/dashboard/editinfo.blade.php --}}
<x-app-layout>
    <div class="max-w-3xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان -->
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-6 flex items-center gap-2">
            <i class="fas fa-user-edit text-yellow-500"></i> {{ __('messages.edit_info') }}
        </h1>

        {{-- ✅ رسالة نجاح --}}
        @if(session('success'))
            <div class="bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 p-4 rounded-lg mb-6 text-center shadow">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        {{-- ✅ عرض الأخطاء --}}
        @if($errors->any())
            <div class="bg-red-100 dark:bg-red-800 text-red-700 dark:text-red-100 p-4 rounded-lg mb-6 shadow">
                <ul class="list-disc list-inside text-sm">
                    @foreach($errors->all() as $error)
                        <li><i class="fas fa-exclamation-triangle"></i> {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ نموذج تعديل البيانات --}}
        <form method="POST" action="{{ route('dashboard.myinfo.update') }}" class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-lg space-y-6">
            @csrf
            @method('PUT')

            {{-- الاسم --}}
            <div>
                <x-label for="name" :value="__('messages.name')" class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-user"></i>
                    </span>
                    <x-input id="name" type="text" name="name" 
                             value="{{ old('name', $user->name) }}" 
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" required />
                </div>
            </div>

            {{-- البريد الإلكتروني --}}
            <div>
                <x-label for="email" :value="__('messages.email')" class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-envelope"></i>
                    </span>
                    <x-input id="email" type="email" name="email" 
                             value="{{ old('email', $user->email) }}" 
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" required />
                </div>
            </div>

            {{-- كلمة المرور (اختياري) --}}
            <div>
                <x-label for="password" :value="__('messages.new_password_optional')" class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-lock"></i>
                    </span>
                    <x-input id="password" type="password" name="password" 
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" />
                </div>
            </div>

            {{-- تأكيد كلمة المرور --}}
            <div>
                <x-label for="password_confirmation" :value="__('messages.confirm_password')" class="text-gray-700 dark:text-gray-200" />
                <div class="relative mt-1">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="fas fa-check"></i>
                    </span>
                    <x-input id="password_confirmation" type="password" name="password_confirmation" 
                             class="pl-10 block w-full dark:bg-gray-700 dark:text-white" />
                </div>
            </div>

            {{-- زر الحفظ --}}
            <div class="text-right">
                <x-button class="bg-yellow-500 hover:bg-yellow-600 text-white shadow px-6 py-2 rounded-lg">
                    <i class="fas fa-save"></i> {{ __('messages.save') }}
                </x-button>
            </div>
        </form>
    </div>

    {{-- ✅ FontAwesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
</x-app-layout>
