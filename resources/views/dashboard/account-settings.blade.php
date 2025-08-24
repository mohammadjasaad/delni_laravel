<x-app-layout>
    <div class="max-w-lg mx-auto px-4 py-10" dir="rtl">
        <h1 class="text-2xl font-bold text-yellow-600 mb-6">⚙️ إعدادات الحساب</h1>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
                <ul class="list-disc ps-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('dashboard.settings.update') }}" class="bg-white p-4 rounded shadow space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-semibold">الاسم</label>
                <input type="text" name="name" class="w-full border rounded px-3 py-2"
                       value="{{ old('name', $user->name) }}" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">البريد الإلكتروني</label>
                <input type="email" name="email" class="w-full border rounded px-3 py-2"
                       value="{{ old('email', $user->email) }}" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold">كلمة المرور الجديدة (اختياري)</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2">
            </div>
            <div>
                <label class="block mb-1 font-semibold">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
            </div>
            <button class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-4 py-2 rounded">حفظ</button>
        </form>
    </div>
</x-app-layout>
