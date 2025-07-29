@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10">
    <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">اتصل بنا</h1>

    <div class="bg-white p-6 rounded-lg shadow-md text-gray-700 space-y-6">
        <p class="text-center">
            إذا كان لديك أي استفسار أو اقتراح، لا تتردد بالتواصل معنا عبر النموذج التالي:
        </p>

        <form method="POST" action="#" class="space-y-4">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">الاسم</label>
                <input type="text" id="name" name="name" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">البريد الإلكتروني</label>
                <input type="email" id="email" name="email" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
            </div>

            <div>
                <label for="message" class="block text-sm font-medium text-gray-700 mb-1">الرسالة</label>
                <textarea id="message" name="message" rows="5" required
                    class="w-full border border-gray-300 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500"></textarea>
            </div>

            <div class="text-center">
                <button type="submit"
                    class="bg-yellow-600 text-white font-semibold px-6 py-2 rounded hover:bg-yellow-700 transition">
                    إرسال
                </button>
            </div>
        </form>

        <div class="text-center text-sm text-gray-400 mt-6">
            أو تواصل معنا عبر البريد: <a href="mailto:support@delni.co" class="text-blue-600 hover:underline">support@delni.co</a>
        </div>
    </div>
</div>
@endsection
