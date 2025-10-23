<x-main-layout title="Delni Taxi - اختر دورك">
    <div class="min-h-screen flex flex-col justify-center items-center bg-gray-50 px-4">
        
        {{-- 🟡 العنوان --}}
        <h1 class="text-3xl font-extrabold text-gray-900 mb-2">DELNI TAXI</h1>
        <p class="text-gray-600 mb-8">🚖 شريكك الموثوق | Your Reliable Ride Partner</p>

        {{-- 🔘 صندوق اختيار الدور --}}
        <div class="bg-white shadow-lg rounded-xl p-6 w-full max-w-md text-center">
            <h2 class="text-lg font-bold text-gray-800 mb-6">اختر دورك | Choose Your Role</h2>

            <div class="grid grid-cols-2 gap-6 mb-6">
                {{-- 🚕 راكب --}}
                <a href="{{ route('taxi.request') }}" 
                   class="border rounded-lg p-4 hover:shadow-lg transition text-center">
                    <div class="text-xl mb-2">🚕</div>
                    <div class="font-bold">راكب | Passenger</div>
                    <div class="text-sm text-gray-500">احجز رحلة | Book a Ride</div>
                </a>

                {{-- 👨‍✈️ سائق --}}
                <a href="{{ route('driver.login') }}" 
                   class="border rounded-lg p-4 hover:shadow-lg transition text-center">
                    <div class="text-xl mb-2">👨‍✈️</div>
                    <div class="font-bold">سائق | Driver</div>
                    <div class="text-sm text-gray-500">ابدأ القيادة | Start Driving</div>
                </a>
            </div>

            {{-- تسجيل الدخول --}}
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">
                🔑 تسجيل الدخول | Sign In
            </a>
        </div>

        {{-- Terms --}}
        <p class="text-xs text-gray-500 mt-8">
            By continuing, you agree to our 
            <a href="{{ route('terms') }}" class="underline">Terms of Service</a>
        </p>
    </div>
</x-main-layout>
