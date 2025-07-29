<footer class="bg-gray-100 border-t mt-12 py-6 text-sm text-gray-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 sm:grid-cols-3 gap-6 items-start">
        
        <!-- Logo + وصف بسيط -->
        <div>
            <h2 class="text-xl font-bold text-yellow-600 mb-2">Delni.co</h2>
            <p>منصتك الذكية لإعلانات السيارات والعقارات في مكان واحد.</p>
        </div>

        <!-- روابط الموقع -->
        <div>
            <h3 class="font-semibold mb-2">روابط سريعة</h3>
            <ul class="space-y-1">
                <li><a href="{{ url('/') }}" class="hover:text-yellow-600">الرئيسية</a></li>
                <li><a href="{{ route('about') }}" class="hover:text-yellow-600">من نحن</a></li>
                <li><a href="{{ route('contact') }}" class="hover:text-yellow-600">اتصل بنا</a></li>
                <li><a href="#" class="hover:text-yellow-600">سياسة الخصوصية</a></li>
                <li><a href="#" class="hover:text-yellow-600">الشروط والأحكام</a></li>
            </ul>
        </div>

        <!-- تواصل معنا -->
        <div>
            <h3 class="font-semibold mb-2">تابعنا</h3>
            <ul class="space-y-1">
                <li><a href="https://www.instagram.com" target="_blank" class="hover:text-yellow-600">Instagram</a></li>
                <li><a href="https://www.facebook.com" target="_blank" class="hover:text-yellow-600">Facebook</a></li>
                <li><a href="https://wa.me/963988779548" target="_blank" class="hover:text-yellow-600">WhatsApp</a></li>
            </ul>
        </div>
    </div>

    <div class="text-center mt-6 text-gray-500">
        © {{ date('Y') }} Delni.co - جميع الحقوق محفوظة.
    </div>
</footer>
