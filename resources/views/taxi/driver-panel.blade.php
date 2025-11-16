@extends('layouts.app')

@section('content')
<div class="p-4 text-center">
    <h2 class="text-xl font-bold mb-2">🚖 وضع السائق نشط</h2>
    <p class="text-gray-600">يتم إرسال موقعك كل ثانيتين...</p>
</div>

<script>
function sendLocation(){
    if(navigator.geolocation){
        navigator.geolocation.getCurrentPosition(function(pos){
            fetch("{{ route('driver.update.location') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({
                    latitude: pos.coords.latitude,
                    longitude: pos.coords.longitude
                })
            });
        });
    }
}

// تحديث الموقع كل 2 ثانية
setInterval(sendLocation, 2000);
</script>
@endsection
