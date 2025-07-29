<x-app-layout>
    <div class="max-w-4xl mx-auto p-6 mt-10 bg-white rounded-lg shadow-md">
        <h2 class="text-2xl font-bold text-center text-yellow-600 mb-4">💬 المحادثة المباشرة</h2>

        <div id="chat-box" class="border rounded p-4 h-96 overflow-y-auto bg-gray-50 mb-4">
            ✅ الرسائل الجديدة ستظهر هنا...
        </div>

        <form id="chat-form" class="flex">
            <input
                type="text"
                id="message-input"
                class="flex-grow border border-gray-300 rounded-l px-4 py-2 focus:outline-none"
                placeholder="اكتب رسالتك..."
                required
            >
            <button
                type="submit"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-r"
            >
                إرسال
            </button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.1/echo.iife.min.js"></script>

    <script>
        // ✅ إعداد Laravel Echo
        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: '{{ env("PUSHER_APP_KEY") }}',
            cluster: '{{ env("PUSHER_APP_CLUSTER") }}',
            wsHost: window.location.hostname,
            wsPort: 6001,
            forceTLS: false,
            disableStats: true,
        });

        const chatBox = document.getElementById('chat-box');
        const form = document.getElementById('chat-form');
        const input = document.getElementById('message-input');

        // إرسال الرسالة إلى السيرفر
        form.addEventListener('submit', async function (e) {
            e.preventDefault();
            const message = input.value.trim();
            if (!message) return;

            await axios.post('{{ route('chat.send') }}', {
                message: message
            });

            input.value = '';
        });

        // الاستماع للرسائل الجديدة من القناة
        window.Echo.channel('chat')
            .listen('NewMessage', (e) => {
                const msg = document.createElement('div');
                msg.className = "p-2 mb-2 rounded bg-yellow-100 text-gray-800";
                msg.innerText = '📩 ' + e.message;
                chatBox.appendChild(msg);
                chatBox.scrollTop = chatBox.scrollHeight;
            });
    </script>
</x-app-layout>
