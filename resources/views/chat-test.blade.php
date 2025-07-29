<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>💬 اختبار WebSocket في Delni.co</title>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>
    <style>
        body { font-family: sans-serif; direction: rtl; padding: 2rem; }
        #messages { border: 1px solid #ccc; padding: 1rem; margin-top: 1rem; min-height: 100px; background: #fdfdfd; }
    </style>
</head>
<body>
    <h2>📡 الرسائل المباشرة (WebSocket)</h2>
    <p>أي رسالة جديدة عبر الحدث ستظهر هنا فورًا:</p>
    <div id="messages">⏳ بانتظار الرسائل...</div>

    <script>
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") }}',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
        });

        window.Echo.channel('chat')
            .listen('NewMessageEvent', function (e) {
                const box = document.getElementById('messages');
                const div = document.createElement('div');
                div.textContent = '💬 ' + e.message;
                box.appendChild(div);
            });
    </script>
</body>
</html>
