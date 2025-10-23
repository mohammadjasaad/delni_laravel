{{-- resources/views/admin/dashboard/index.blade.php --}}
<x-app-layout :isAdmin="true">
    <div class="max-w-7xl mx-auto py-10 px-6">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-extrabold text-yellow-600 mb-8 text-center">
            🛠️ {{ __('messages.admin_dashboard') }}
        </h1>

        {{-- ✅ قسم الإحصائيات --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12">
            <x-admin.stat-card icon="👤" label="{{ __('messages.users_count') }}" value="{{ $userCount }}" color="blue"/>
            <x-admin.stat-card icon="📢" label="{{ __('messages.ads_count') }}" value="{{ $adCount }}" color="green"/>
            <x-admin.stat-card icon="⭐" label="{{ __('messages.featured_ads_count') }}" value="{{ $featuredAdsCount }}" color="yellow"/>
            <x-admin.stat-card icon="🚨" label="{{ __('messages.emergency_reports_count') }}" value="{{ $reportCount }}" color="red"/>
            <x-admin.stat-card icon="👁️" label="{{ __('messages.visitors_count') }}" value="{{ $visitorsCount }}" color="purple"/>
            <x-admin.stat-card icon="🚖" label="{{ __('messages.drivers_count') }}" value="{{ $driversCount }}" color="indigo"/>
        </div>

        {{-- 🎫 إحصائيات التذاكر --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 mb-12">
            <x-admin.stat-card icon="🎫" label="{{ __('messages.tickets_total') }}" value="{{ $ticketsTotal }}" color="blue"/>
            <x-admin.stat-card icon="🆕" label="{{ __('messages.ticket_status_new') }}" value="{{ $ticketsNew }}" color="yellow"/>
            <x-admin.stat-card icon="⚙️" label="{{ __('messages.ticket_status_processing') }}" value="{{ $ticketsProcessing }}" color="orange"/>
            <x-admin.stat-card icon="✅" label="{{ __('messages.ticket_status_answered') }}" value="{{ $ticketsAnswered }}" color="green"/>
            <x-admin.stat-card icon="🚫" label="{{ __('messages.ticket_status_closed') }}" value="{{ $ticketsClosed }}" color="red"/>
        </div>

        {{-- 📈 الرسوم البيانية --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <x-admin.chart-card 
                id="userGrowthChart"
                title="{{ __('messages.user_growth') }}"
                :labels="$userGrowth->keys()"
                :data="$userGrowth->values()"
            />

            <x-admin.chart-card 
                id="adGrowthChart"
                title="{{ __('messages.ad_growth') }}"
                :labels="$adGrowth->keys()"
                :data="$adGrowth->values()"
            />
        </div>

        {{-- 📢 آخر 5 إعلانات --}}
        <x-admin.latest-list 
            title="📢 {{ __('messages.latest_ads') }}" 
            :items="$latestAds" 
            viewRoute="ads.show" 
            :empty="__('messages.no_ads')" 
            route="ads.index"
        />

        {{-- 🎫 آخر 5 تذاكر --}}
        <x-admin.latest-list 
            title="🎫 {{ __('messages.latest_tickets') }}" 
            :items="$latestTickets" 
            viewRoute="admin.support_tickets.show" 
            :empty="__('messages.no_tickets')" 
            route="admin.support_tickets.index"
        />

        {{-- 👁️ آخر 5 زوار --}}
        <x-admin.latest-list 
            title="👁️ {{ __('messages.latest_visitors') }}" 
            :items="$latestVisitors" 
            :empty="__('messages.no_visitors')" 
            route="admin.visitors.index"
        />

{{-- 🚀 الروابط السريعة --}}
<div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-12">
    <x-admin.quick-link route="admin.users.index" icon="👤" label="{{ __('messages.manage_users') }}" color="blue"/>
    <x-admin.quick-link route="admin.support_tickets.index" icon="🎫" label="{{ __('messages.support_tickets') }}" color="green"/>
    <x-admin.quick-link route="admin.emergency_reports.index" icon="🚨" label="{{ __('messages.manage_emergency_reports') }}" color="red"/>
    <x-admin.quick-link route="admin.visitors.index" icon="👁️" label="{{ __('messages.visitors') }}" color="purple"/>
    <x-admin.quick-link route="admin.statistics" icon="📊" label="{{ __('messages.statistics') }}" color="yellow"/>

    {{-- 📢 إدارة البانرات --}}
    <x-admin.quick-link route="banners.index" icon="📢" label="{{ __('messages.manage_banners') }}" color="indigo"/>

    {{-- 🖼️ إدارة بانرات المول --}}
    <x-admin.quick-link route="mall-banners.index" icon="🖼️" label="إدارة بانرات المول" color="pink"/>
</div>

    {{-- 📊 Chart.js --}}
    @vite('resources/js/admin-dashboard.js')

</x-app-layout>
