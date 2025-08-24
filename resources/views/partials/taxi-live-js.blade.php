{{-- partials/taxi-live-js.blade.php --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
    // ======= الأصوات =======
    const arrivalSound = new Audio('/sounds/arrival.mp3');
    const messageSound = new Audio('/sounds/message.mp3');
    const statusChangeSound = new Audio('/sounds/status-change.mp3');

    // ======= عناصر DOM =======
    const notifBanner = document.getElementById("notifBanner");
    const notifToggle = document.getElementById("notifToggle");
    const statusBar   = document.getElementById("statusBar");
    let notifEnabled  = false;
    let lastMessageCount = 0;
    let lastDriverStatus = @json($driver->status ?? '');
    let lastOrderStatus  = @json($order->status ?? '');
    let arrivalAnnounced = false;

    // ======= بيانات ابتدائية =======
    const driverInitial = {
        lat: parseFloat("{{ $driver->latitude }}"),
        lng: parseFloat("{{ $driver->longitude }}"),
        name: @json($driver->name),
        car:  @json($driver->car_number),
        phone:@json($driver->phone),
        status:@json($driver->status),
    };
    const user = {
        lat: parseFloat("{{ $order->pickup_latitude }}"),
        lng: parseFloat("{{ $order->pickup_longitude }}")
    };
    const orderId = "{{ $order->id ?? 0 }}";

    // ======= أدوات مساعدة =======
    function kmDistance(aLat,aLng,bLat,bLng){
        const R=6371, dLat=(bLat-aLat)*Math.PI/180, dLng=(bLng-aLng)*Math.PI/180;
        const s1=Math.sin(dLat/2), s2=Math.sin(dLng/2);
        const A=s1*s1 + Math.cos(aLat*Math.PI/180)*Math.cos(bLat*Math.PI/180)*s2*s2;
        return R * (2 * Math.atan2(Math.sqrt(A), Math.sqrt(1-A)));
    }
    function statusToText(s){
        if(!s) return '—';
        if(s === 'قيد التنفيذ') return 'تم إرسال طلبك! السائق في طريقه إليك.';
        if(s === 'بدأت الرحلة') return '🚖 الرحلة بدأت! استمتع.';
        if(s === 'منتهي')       return '✅ الرحلة منتهية.';
        if(s === 'ملغي')        return '🚫 تم إلغاء الطلب.';
        return '🚧 حالة الطلب: ' + s;
    }
    function colorForStatus(s){
        if(s === 'قيد التنفيذ') return 'bg-yellow-500';
        if(s === 'بدأت الرحلة') return 'bg-blue-600';
        if(s === 'منتهي')       return 'bg-green-600';
        if(s === 'ملغي')        return 'bg-gray-600';
        return 'bg-indigo-600';
    }
    function updateStatusBarDisplay(status){
        statusBar.textContent = '🚦 ' + (status || 'غير معروف');
        statusBar.className = `w-full text-center py-3 font-bold text-white ${colorForStatus(status)}`;
    }

    // ======= الخريطة =======
    document.addEventListener("DOMContentLoaded", function () {
        // خريطة مصغرة
        const pickupMap = L.map('pickup-map').setView(user.lat, user.lng], 15);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 19 }).addTo(pickupMap);
        L.marker(user.lat, user.lng]).addTo(pickupMap).bindPopup("📍 موقع الراكب").openPopup();

        // الخريطة الكبيرة
        const map = L.map('map').setView(user.lat, user.lng], 12);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

        const taxiIcon = L.icon({ iconUrl: '/images/taxi-icon.png', iconSize: [36,36], iconAnchor:[18,36] });
        window.driverMarker = L.marker(driverInitial.lat, driverInitial.lng], { icon: taxiIcon }).addTo(map);
        const userMarker = L.circleMarker(user.lat, user.lng], { radius:8, fillColor:"#007BFF", color:"#fff", weight:2, fillOpacity:0.9 }).addTo(map);
        window.pathLine = L.polyline([driverInitial.lat, driverInitial.lng],[user.lat,user.lng]], { color:'blue' }).addTo(map);
    });

    // ======= Laravel Echo (تحديث حي من Pusher) =======
    window.Echo.channel(`driver.location.${orderId}`)
        .listen(".DriverLocationUpdated", (data) => {
            if (window.driverMarker) {
                driverMarker.setLatLng(data.latitude, data.longitude]);
                pathLine.setLatLngs([data.latitude, data.longitude], [user.lat, user.lng]]);

                const km = kmDistance(data.latitude, data.longitude, user.lat, user.lng);
                document.getElementById('eta').textContent = km < 0.05 ? "🚖 السائق وصل!" : `${km.toFixed(2)} كم`;
            }
        });

    // ======= التحديث الاحتياطي من السيرفر (كل دقيقة) =======
    async function refreshLive(){
        try{
            const res = await fetch("{{ route('taxi.order.json', $order->id) }}", { cache: 'no-store' });
            if(!res.ok) return;
            const { order, driver } = await res.json();

            document.getElementById('lastUpdate').textContent = new Date().toLocaleTimeString();

            if(order?.status) updateStatusBarDisplay(order.status);

            if(driver){
                document.getElementById('dName').textContent = driver.name || '';
                document.getElementById('dPhone').textContent = driver.phone || 'غير متوفر';
                document.getElementById('dStatus').textContent = driver.status || '';
            }
        }catch(e){ console.error(e); }
    }
    setInterval(refreshLive, 60000);
    refreshLive();
</script>
