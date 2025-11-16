@extends('layouts.app')

@section('content')
<div class="p-4" style="height: calc(100vh - 20px); display:flex; flex-direction:column;">

<div id="messages" class="flex-1 overflow-y-auto mb-3">
    @foreach($messages as $msg)
        <div class="my-1 {{ $msg->sender_type=='driver'?'text-right':'' }}">
            <span class="px-3 py-2 rounded-lg inline-block 
                {{ $msg->sender_type=='driver'?'bg-yellow-400':'bg-gray-200' }}">
                {{ $msg->message }}
            </span>
        </div>
    @endforeach
</div>

<div class="flex gap-2">
    <input id="msgInput" class="flex-1 border rounded px-3 py-2" placeholder="اكتب رسالة...">
    <button id="sendBtn" class="bg-yellow-400 px-4 rounded">إرسال</button>
</div>

</div>

<script src="{{ asset('js/app.js') }}"></script>

<script>
var orderId = {{ $order->id }};

// ✅ استقبال الرسائل لحظيًا
window.Echo.channel('taxi-chat.'+orderId)
.listen('.TaxiMessageSent', (e) => {
    let box = document.getElementById('messages');
    box.innerHTML += `
        <div class="my-1">
            <span class="px-3 py-2 rounded-lg inline-block bg-gray-200">${e.message.message}</span>
        </div>
    `;
    box.scrollTop = box.scrollHeight;
});

// ✅ إرسال الرسالة
document.getElementById('sendBtn').onclick = function(){
    fetch("{{ route('taxi.message.send') }}", {
        method: "POST",
        headers: {"Content-Type":"application/json", "X-CSRF-TOKEN":"{{ csrf_token() }}"},
        body: JSON.stringify({
            order_id: orderId,
            sender_type: "driver", // ✅ الفرق هنا فقط
            message: document.getElementById('msgInput').value
        })
    });

    document.getElementById('msgInput').value = "";
}
</script>
@endsection
