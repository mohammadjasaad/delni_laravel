import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

window.Pusher = Pusher;

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: import.meta.env.VITE_PUSHER_APP_KEY,
  cluster: import.meta.env.VITE_PUSHER_APP_CLUSTER || 'mt1',
  forceTLS: (import.meta.env.VITE_PUSHER_SCHEME || 'https') === 'https',
  wsHost: import.meta.env.VITE_PUSHER_HOST || undefined,
  wsPort: import.meta.env.VITE_PUSHER_PORT ? Number(import.meta.env.VITE_PUSHER_PORT) : undefined,
  wssPort: import.meta.env.VITE_PUSHER_PORT ? Number(import.meta.env.VITE_PUSHER_PORT) : undefined,
  enabledTransports: ['ws', 'wss'],
});
