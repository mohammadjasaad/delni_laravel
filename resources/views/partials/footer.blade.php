<footer class="bg-gray-100 text-gray-700 text-sm mt-10 border-t">
  <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-6">

    {{-- روابط سريعة --}}
    <div>
      <h3 class="font-bold mb-2">{{ __('messages.quick_links') }}</h3>
      <ul class="space-y-1">
        <li><a href="{{ route('home') }}" class="hover:text-yellow-500">{{ __('messages.home') }}</a></li>
        <li><a href="{{ route('ads.index') }}" class="hover:text-yellow-500">{{ __('messages.ads') }}</a></li>
        <li><a href="{{ route('about') }}" class="hover:text-yellow-500">{{ __('messages.about') }}</a></li>
        <li><a href="{{ route('contact') }}" class="hover:text-yellow-500">{{ __('messages.contact') }}</a></li>
      </ul>
    </div>

    {{-- حول دلني --}}
    <div>
      <h3 class="font-bold mb-2">{{ __('messages.about') }}</h3>
      <p class="text-gray-600 text-sm">
        {{ __('messages.footer_about_text') }}
      </p>
    </div>

    {{-- حقوق النشر --}}
    <div class="text-center md:text-right">
      <p>© {{ now()->year }} {{ __('messages.site_name', ['name' => 'Delni.co']) }}</p>
      <p>{{ __('messages.all_rights_reserved') }}</p>
    </div>

  </div>
</footer>
