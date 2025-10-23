import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: import.meta.env.VITE_PUSHER_APP_KEY ?? 'bca652eb41222724bade', // ✅ من .env
    cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER ?? 'mt1',
    wsHost: window.location.hostname,
    wsPort: 6001,          // المنفذ الافتراضي عند استخدام websockets
    wssPort: 443,          // المنفذ عند HTTPS
    forceTLS: true,        // ✅ ضروري لأن موقعك https://delni.co
    encrypted: true,
    disableStats: true,
    enabledTransports: ['ws', 'wss'], // ✅ ليتعامل مع السيرفر عبر WebSocket
});
