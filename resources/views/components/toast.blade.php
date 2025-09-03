{{-- resources/views/components/toast.blade.php --}}
<div id="toastAlert" 
     class="fixed top-4 left-1/2 transform -translate-x-1/2 opacity-0 -translate-y-5
            transition duration-700 ease-out flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg z-50 min-w-[300px] max-w-[400px] text-center">
    <span id="toastIcon" class="text-2xl"></span>
    <span id="toastMessage" class="text-sm font-semibold flex-1"></span>
    <button id="closeToast" class="text-lg font-bold hover:text-red-600">❌</button>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toast      = document.getElementById("toastAlert");
        const toastIcon  = document.getElementById("toastIcon");
        const toastMsg   = document.getElementById("toastMessage");
        const closeBtn   = document.getElementById("closeToast");

        // ✅ وظيفة إظهار التوست
        window.showToast = function(type = "success", message = "{{ __('messages.success') ?? '✅ Done successfully!' }}") {
            // إعادة تعيين الكلاسات
            toast.className = "fixed top-4 left-1/2 transform -translate-x-1/2 opacity-0 -translate-y-5 transition duration-700 ease-out flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg z-50 min-w-[300px] max-w-[400px] text-center";

            switch(type) {
                case "success":
                    toast.classList.add("bg-green-100","border","border-green-300","text-green-800");
                    toastIcon.textContent = "✅";
                    break;
                case "error":
                    toast.classList.add("bg-red-100","border","border-red-300","text-red-800");
                    toastIcon.textContent = "❌";
                    break;
                case "warning":
                    toast.classList.add("bg-yellow-100","border","border-yellow-300","text-yellow-800");
                    toastIcon.textContent = "⚠️";
                    break;
                case "info":
                    toast.classList.add("bg-blue-100","border","border-blue-300","text-blue-800");
                    toastIcon.textContent = "ℹ️";
                    break;
            }

            toastMsg.textContent = message;

            // إظهار
            setTimeout(() => {
                toast.classList.remove("opacity-0","-translate-y-5");
                toast.classList.add("opacity-100","translate-y-0");
            }, 200);

            // إخفاء تلقائي بعد 5 ثواني
            const autoHide = setTimeout(() => hideToast(), 5000);

            // زر إغلاق يدوي
            closeBtn.addEventListener("click", () => {
                clearTimeout(autoHide);
                hideToast();
            });
        };

        // ✅ وظيفة إخفاء
        function hideToast() {
            toast.classList.remove("opacity-100","translate-y-0");
            toast.classList.add("opacity-0","-translate-y-5");
        }

        // ✅ تشغيل أوتوماتيكي إذا فيه Session Messages
        @if(session('success'))
            showToast("success", "{{ session('success') }}");
        @endif

        @if(session('error'))
            showToast("error", "{{ session('error') }}");
        @endif

        @if(session('warning'))
            showToast("warning", "{{ session('warning') }}");
        @endif

        @if(session('info'))
            showToast("info", "{{ session('info') }}");
        @endif
    });
</script>
