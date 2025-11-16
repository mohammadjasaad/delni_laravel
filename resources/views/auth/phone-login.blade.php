<x-app-layout>
<div class="max-w-md mx-auto mt-16 bg-white dark:bg-gray-800 p-8 rounded-2xl shadow-lg text-center">

    <h1 class="text-2xl font-bold mb-6 text-gray-800 dark:text-white">تسجيل الدخول عبر واتساب</h1>

    <input id="phone" type="text" placeholder="مثال: 0988xxxxxx"
           class="w-full mb-4 px-4 py-3 border rounded-lg dark:bg-gray-700 dark:text-white">

    <button id="sendBtn"
            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-lg mb-4 transition">
        إرسال رمز التحقق
    </button>

    <div id="verifyBox" class="hidden">
        <input id="code" type="text" placeholder="ادخل رمز التحقق"
               class="w-full px-4 py-3 border rounded-lg mb-4 dark:bg-gray-700 dark:text-white">

        <button id="verifyBtn"
                class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg transition">
            تأكيد وتسجيل الدخول
        </button>
    </div>
</div>

<script>
document.getElementById('sendBtn').onclick = function(){

    fetch("{{ route('send.code') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            phone: document.getElementById('phone').value
        })
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){
            document.getElementById('verifyBox').classList.remove('hidden');
        } else {
            alert("⚠️ فشل إرسال الرمز");
        }
    });
};

document.getElementById('verifyBtn').onclick = function(){

    fetch("{{ route('verify.code') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            phone: document.getElementById('phone').value,
            code: document.getElementById('code').value
        })
    })
    .then(res => res.json())
    .then(res => {
        if(res.status === 'success'){
            window.location.href = res.redirect ?? "/";
        } else {
            alert("⚠️ الرمز غير صحيح");
        }
    });
};
</script>
</x-app-layout>
