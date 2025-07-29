<x-app-layout>
    <div class="max-w-6xl mx-auto py-10 px-4">

        {{-- ✅ عنوان الصفحة --}}
        <h1 class="text-3xl font-bold text-gray-800 mb-6">{{ __('messages.dashboard') }}</h1>

        {{-- ✅ رسالة ترحيبية --}}
        <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
            {{ __('messages.welcome') }} {{ Auth::user()->name }} 👋
        </div>

        {{-- ✅ زر المفضلة + الطلبات --}}
        <div class="flex flex-wrap gap-4 justify-center mb-10">
            <a href="{{ route('dashboard.favorites') }}" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded shadow">
                ❤️ {{ __('messages.my_favorites') }}
            </a>
            <a href="{{ route('dashboard.myorders') }}" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded shadow">
                🚖 {{ __('messages.my_orders') }}
            </a>
        </div>

        {{-- ✅ إشعارات المستخدم --}}
        @if(auth()->user()->notifications->count())
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">🔔 إشعاراتك</h2>
                <ul class="space-y-2">
                    @foreach(auth()->user()->notifications as $notification)
                        <li class="bg-white border rounded p-3 text-sm text-gray-700 shadow flex justify-between items-center">
                            <span>{{ $notification->data['message'] }}</span>
                            <span class="text-xs text-gray-400">{{ $notification->created_at->diffForHumans() }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- ✅ بطاقات الوصول السريع --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            {{-- إعلان جديد --}}
            <x-dashboard.card 
                route="dashboard.ads.create" 
                icon="➕" 
                title="{{ __('messages.add_new_ad') }}" 
                desc="{{ __('messages.add_new_ad_description') }}" 
            />

            {{-- إعلاناتي --}}
            <x-dashboard.card 
                route="dashboard.myads" 
                icon="📢" 
                title="{{ __('messages.my_ads') }}" 
                desc="{{ __('messages.view_manage_ads') }}" 
            />

            {{-- بياناتي --}}
            <x-dashboard.card 
                route="dashboard.myinfo" 
                icon="👤" 
                title="{{ __('messages.my_info') }}" 
                desc="{{ __('messages.view_edit_info') }}" 
            />

            {{-- تغيير كلمة المرور --}}
            <x-dashboard.card 
                route="dashboard.editpassword" 
                icon="🔐" 
                title="{{ __('messages.change_password') }}" 
                desc="تحديث كلمة مرور حسابك بأمان." 
            />

            {{-- إحصائيات الموقع --}}
            <x-dashboard.card 
                route="dashboard.statistics" 
                icon="📊" 
                title="إحصائيات الموقع" 
                desc="عرض ملخص بيانات المستخدمين والإعلانات والخدمات." 
            />

            {{-- بلاغات الطوارئ --}}
            <x-dashboard.card 
                route="emergency_reports.index" 
                icon="📋" 
                title="بلاغات الطوارئ" 
                desc="عرض ومراجعة جميع البلاغات المرسلة من المستخدمين." 
            />

            {{-- إحصائيات مراكز الطوارئ --}}
            <x-dashboard.card 
                route="emergency.stats" 
                icon="🆘" 
                title="إحصائيات الطوارئ" 
                desc="معلومات حول المراكز والبلاغات الأكثر نشاطًا." 
            />
        </div>

    </div>
</x-app-layout>
