
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <section class="min-h-screen flex flex-col bg-gray-50 text-gray-900 transition-colors duration-500 dark:bg-gray-950 dark:text-gray-100">


<header class="relative bg-gradient-to-r from-yellow-400 via-yellow-500 to-yellow-600 dark:from-yellow-500 dark:to-yellow-600 text-gray-900 dark:text-white py-14 md:py-20 shadow-xl overflow-hidden">
    
    <div class="absolute inset-0 bg-white/10 dark:bg-black/40 mix-blend-overlay"></div>

    
    <div class="relative max-w-6xl mx-auto px-6 text-center">
        <h1 class="hero-title text-5xl md:text-6xl font-extrabold mb-4 tracking-tight opacity-0 translate-y-6">
            🚖 Delni Taxi
        </h1>

        <p class="hero-subtitle text-lg md:text-2xl font-medium opacity-0 translate-y-6 delay-200">
            <span class="text-gray-800 dark:text-gray-200">شريكك الموثوق في التنقل اليومي</span> |
            <span class="font-semibold text-black dark:text-yellow-200">Your Reliable Ride Partner</span>
        </p>

        <div class="hero-buttons mt-10 flex flex-col sm:flex-row justify-center gap-4 opacity-0 translate-y-6 delay-400">
<a href="<?php echo e(route('taxi.request.page')); ?>"
               class="bg-yellow-400 hover:bg-yellow-300 text-black font-bold py-3 px-8 rounded-xl shadow-lg transition transform hover:scale-105">
                🚕 اطلب سيارة الآن
            </a>
            <a href="<?php echo e(route('driver.login')); ?>"
               class="border border-yellow-400 text-yellow-700 dark:text-yellow-300 hover:bg-yellow-400 hover:text-black font-semibold py-3 px-8 rounded-xl transition transform hover:scale-105">
                👨‍✈️ تسجيل دخول السائقين
            </a>
        </div>
    </div>
</header>


<style>
@keyframes fadeUp {
  0% { opacity: 0; transform: translateY(20px); }
  100% { opacity: 1; transform: translateY(0); }
}

.hero-title {
  animation: fadeUp 1s ease forwards;
}

.hero-subtitle {
  animation: fadeUp 1.2s ease forwards;
  animation-delay: 0.2s;
}

.hero-buttons {
  animation: fadeUp 1.4s ease forwards;
  animation-delay: 0.4s;
}
</style>

        
        <section class="relative w-full h-[500px] md:h-[600px] overflow-hidden">
            <div id="taxiMap" class="absolute inset-0 w-full h-full z-0 opacity-100 transition-opacity duration-700"></div>

            
            <div id="locationStatus"
                 class="hidden absolute top-5 left-1/2 transform -translate-x-1/2 bg-yellow-400 text-black font-semibold px-6 py-3 rounded-full shadow-lg z-30 opacity-0 transition-opacity duration-700">
                جارٍ تحديد موقعك...
            </div>

            
            <div id="driverAlert"
                 class="hidden absolute bottom-32 left-1/2 transform -translate-x-1/2 bg-yellow-400 text-black font-semibold px-6 py-3 rounded-xl shadow-xl animate-bounce z-20">
                🚗 أقرب سائق يقترب منك!
            </div>

            
            <div id="distanceInfo"
                 class="absolute bottom-14 left-1/2 transform -translate-x-1/2 bg-black/70 text-yellow-300 text-sm md:text-base font-semibold px-5 py-2 rounded-lg shadow-lg z-20">
                🚘 أقرب سائق يبعد: <span id="distanceValue">—</span> كم — 🕒 يصل خلال <span id="etaValue">—</span> دقيقة
            </div>

            
            <button id="refreshLocationBtn"
                    class="absolute bottom-4 right-4 bg-yellow-500 hover:bg-yellow-400 text-black font-semibold px-5 py-3 rounded-full shadow-lg flex items-center gap-2 transition z-30">
                📍 <span>تحديث موقعي</span>
            </button>
        </section>

        
        <footer class="bg-gray-900 text-gray-400 py-10 mt-0 border-t border-gray-800">
            <div class="max-w-7xl mx-auto px-6 text-center space-y-3">
                <p>© <?php echo e(date('Y')); ?> <span class="text-yellow-400 font-semibold">Delni.co</span> — جميع الحقوق محفوظة</p>
                <div class="flex flex-wrap justify-center gap-4 text-sm">
                    <a href="<?php echo e(route('home')); ?>" class="hover:text-yellow-400">🏠 الرئيسية</a>
                    <a href="<?php echo e(route('contact')); ?>" class="hover:text-yellow-400">📞 اتصل بنا</a>
                    <a href="<?php echo e(route('terms')); ?>" class="hover:text-yellow-400">📜 الشروط والأحكام</a>
                    <a href="<?php echo e(route('privacy')); ?>" class="hover:text-yellow-400">🔒 سياسة الخصوصية</a>
                </div>
            </div>
        </footer>
    </section>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    
    <audio id="carSound" src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_2d61207f4d.mp3?filename=car-approaching-ambient-11087.mp3" preload="auto"></audio>
    <audio id="successSound" src="https://cdn.pixabay.com/download/audio/2023/03/21/audio_f5e1a8c6d2.mp3?filename=success-1-6297.mp3" preload="auto"></audio>
    <audio id="driverNearSound" src="https://cdn.pixabay.com/download/audio/2022/03/16/audio_3c9b2baddd.mp3?filename=notification-tone-28643.mp3" preload="auto"></audio>

    <style>
        html { color-scheme: dark light; }
        .loading-spinner {
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-top: 3px solid black;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            animation: spin 1s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const mapLayerLight = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
            const mapLayerDark = 'https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png';
            const mapElement = document.getElementById('taxiMap');

            const map = L.map('taxiMap', { zoomControl: false }).setView([33.5138, 36.2765], 13);
            let currentLayer = L.tileLayer(mapLayerDark, { subdomains: 'abcd', maxZoom: 19 }).addTo(map);

            // 🌙 تبديل الخريطة مع تأثير Fade
            function updateMapTheme() {
                mapElement.style.opacity = '0';
                setTimeout(() => {
                    const isDarkMode = document.documentElement.classList.contains('dark');
                    const newLayer = L.tileLayer(isDarkMode ? mapLayerDark : mapLayerLight, { subdomains: 'abcd', maxZoom: 19 });
                    map.removeLayer(currentLayer);
                    newLayer.addTo(map);
                    currentLayer = newLayer;
                    mapElement.style.opacity = '1';
                }, 400);
            }

            // 👂 راقب تغيّر الوضع الليلي
            const observer = new MutationObserver(() => updateMapTheme());
            observer.observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

            // 🚗 باقي المنطق كما هو
            let driverMarkers = [];
            let alertedDrivers = new Set();
            let userMarker = null;
            let userPosition = { lat: 33.5138, lng: 36.2765 };
            let pulseCircle = null;

            const alertBox = document.getElementById('driverAlert');
            const statusBox = document.getElementById('locationStatus');
            const carSound = document.getElementById('carSound');
            const successSound = document.getElementById('successSound');
            const driverNearSound = document.getElementById('driverNearSound');
            const distanceValue = document.getElementById('distanceValue');
            const etaValue = document.getElementById('etaValue');
            const refreshBtn = document.getElementById('refreshLocationBtn');
            const refreshText = refreshBtn.querySelector('span');

            const CarIcon = L.DivIcon.extend({
                options: {
                    className: '',
                    html: '<div style="transform: rotate(0deg); transition: transform 0.6s ease;"><span style="font-size:24px;">🚗</span></div>',
                    iconSize: [30, 30],
                    iconAnchor: [15, 15]
                }
            });

            function showStatus(message, success = false) {
                statusBox.textContent = message;
                statusBox.classList.remove('hidden');
                statusBox.classList.add('opacity-100');
                statusBox.style.backgroundColor = success ? '#4ade80' : '#facc15';
                if (success) successSound.play().catch(() => {});
                setTimeout(() => {
                    statusBox.classList.remove('opacity-100');
                    statusBox.classList.add('opacity-0');
                    setTimeout(() => statusBox.classList.add('hidden'), 800);
                }, 2500);
            }

            function addUserMarker(lat, lng) {
                if (userMarker) map.removeLayer(userMarker);
                userMarker = L.marker([lat, lng]).addTo(map).bindPopup("<b>📍 موقعك الحالي</b>").openPopup();
            }

            function generateDrivers(lat, lng) {
                driverMarkers.forEach(d => map.removeLayer(d.marker));
                driverMarkers = [];
                for (let i = 0; i < 8; i++) {
                    const driverLat = lat + (Math.random() - 0.5) * 0.02;
                    const driverLng = lng + (Math.random() - 0.5) * 0.02;
                    const marker = L.marker([driverLat, driverLng], { icon: new CarIcon() }).addTo(map)
                        .bindPopup("🚖 سائق قريب منك");
                    driverMarkers.push({ marker, lat: driverLat, lng: driverLng });
                }
            }

            function calcDistance(lat1, lng1, lat2, lng2) {
                const R = 6371;
                const dLat = (lat2 - lat1) * Math.PI / 180;
                const dLng = (lng2 - lng1) * Math.PI / 180;
                const a = Math.sin(dLat/2)**2 + Math.cos(lat1 * Math.PI/180) * Math.cos(lat2 * Math.PI/180) * Math.sin(dLng/2)**2;
                return R * (2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a)));
            }

            function moveDriversTowardUser() {
                let minDistance = Infinity;
                driverMarkers.forEach(driver => {
                    const latDiff = userPosition.lat - driver.lat;
                    const lngDiff = userPosition.lng - driver.lng;
                    const newLat = driver.lat + latDiff * 0.04 + (Math.random() - 0.5) * 0.0007;
                    const newLng = driver.lng + lngDiff * 0.04 + (Math.random() - 0.5) * 0.0007;
                    driver.marker.setLatLng([newLat, newLng]);
                    driver.lat = newLat; driver.lng = newLng;
                    const distance = calcDistance(userPosition.lat, userPosition.lng, driver.lat, driver.lng);
                    if (distance < 0.2 && !alertedDrivers.has(driver)) {
                        alertedDrivers.add(driver);
                        alertBox.classList.remove('hidden');
                        driverNearSound.play().catch(() => {});
                        carSound.play().catch(() => {});
                        setTimeout(() => alertBox.classList.add('hidden'), 4000);
                    }
                    if (distance < minDistance) minDistance = distance;
                });
                if (isFinite(minDistance)) {
                    const speed = 30;
                    const timeMinutes = (minDistance / speed) * 60;
                    distanceValue.textContent = minDistance.toFixed(2);
                    etaValue.textContent = timeMinutes.toFixed(1);
                }
            }

            function showPulseEffect(lat, lng) {
                if (pulseCircle) map.removeLayer(pulseCircle);
                pulseCircle = L.circle([lat, lng], {
                    radius: 20, color: '#facc15', fillColor: '#facc15', fillOpacity: 0.3
                }).addTo(map);
                let radius = 20;
                const expand = setInterval(() => {
                    radius += 30;
                    pulseCircle.setRadius(radius);
                    if (radius > 300) { map.removeLayer(pulseCircle); clearInterval(expand); }
                }, 100);
            }

            function updateLocation(auto = false) {
                if (!auto) {
                    refreshBtn.disabled = true;
                    refreshBtn.classList.add('opacity-70', 'cursor-not-allowed');
                    refreshText.textContent = 'جارٍ تحديد موقعك...';
                    refreshBtn.insertAdjacentHTML('afterbegin', '<div class="loading-spinner"></div>');
                }
                showStatus('جارٍ تحديد موقعك...');
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((pos) => {
                        userPosition.lat = pos.coords.latitude;
                        userPosition.lng = pos.coords.longitude;
                        map.setView([userPosition.lat, userPosition.lng], 14);
                        addUserMarker(userPosition.lat, userPosition.lng);
                        generateDrivers(userPosition.lat, userPosition.lng);
                        showPulseEffect(userPosition.lat, userPosition.lng);
                        showStatus('✅ تم تحديد موقعك بنجاح', true);
                        if (!auto) {
                            setTimeout(() => {
                                refreshBtn.disabled = false;
                                refreshBtn.classList.remove('opacity-70', 'cursor-not-allowed');
                                refreshBtn.querySelector('.loading-spinner')?.remove();
                                refreshText.textContent = 'تحديث موقعي';
                            }, 1500);
                        }
                    });
                }
            }

            updateLocation(true);
            setInterval(moveDriversTowardUser, 3000);
            refreshBtn.addEventListener('click', () => updateLocation(false));
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/taxi/landing.blade.php ENDPATH**/ ?>