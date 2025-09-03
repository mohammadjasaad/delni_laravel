{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-white dark:bg-gray-900 border-t mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">

        {{-- ✅ القسم الأول: الشعار والوصف --}}
        <div class="flex flex-col items-center md:items-start space-y-3">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="{{ asset('images/delnilogo.png') }}" alt="Delni Logo" class="h-10">
                <span class="text-lg font-bold text-gray-800 dark:text-gray-100">Delni.co</span>
            </a>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('messages.footer_about', ['app' => 'Delni.co']) }}
            </p>
        </div>

        {{-- ✅ القسم الثاني: روابط سريعة --}}
        <div>
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ __('messages.quick_links') }}</h3>
            <ul class="space-y-2 text-sm">
                <li><a href="{{ route('home') }}" class="hover:text-yellow-500">{{ __('messages.home') }}</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-yellow-500">{{ __('messages.about') }}</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-yellow-500">{{ __('messages.contact') }}</a></li>
<li><a href="{{ route('terms') }}" class="hover:text-yellow-500">{{ __('messages.terms_conditions') }}</a></li>
<li><a href="{{ route('privacy') }}" class="hover:text-yellow-500">{{ __('messages.privacy_policy') }}</a></li>
<li><a href="{{ route('faq') }}" class="hover:text-yellow-500">{{ __('messages.faq_title') }}</a></li>
            </ul>
        </div>

        {{-- ✅ القسم الثالث: تواصل معنا --}}
        <div>
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3">{{ __('messages.contact_us') }}</h3>
            <ul class="space-y-2 text-sm">
                <li>📞 <a href="tel:+963988779548" class="hover:text-yellow-500">+963 988 779 548</a></li>
                <li>💬 <a href="https://wa.me/963988779548" target="_blank" class="hover:text-green-500">WhatsApp</a></li>
                <li>✉️ <a href="mailto:info@delni.co" class="hover:text-yellow-500">info@delni.co</a></li>
            </ul>
        </div>
    </div>

    {{-- ✅ حقوق النشر --}}
    <div class="bg-gray-100 dark:bg-gray-800 text-center py-3 text-sm text-gray-600 dark:text-gray-400">
        © {{ date('Y') }} Delni.co — {{ __('messages.all_rights_reserved') }}
    </div>
</footer>
