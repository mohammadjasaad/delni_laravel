{{-- resources/views/components/toast.blade.php --}}
<div id="toastContainer" class="fixed top-6 right-6 z-50 space-y-3 w-full max-w-sm"></div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById("toastContainer");

        // ✅ وظيفة إنشاء Toast جديد
        window.showToast = function(type = "success", message = "تمت العملية بنجاح ✅") {
            const toast = document.createElement("div");
            toast.className = "flex items-center justify-between px-4 py-3 rounded-lg shadow-lg transition transform opacity-0 -translate-y-3";
            
            // ألوان وأيقونات حسب النوع
            let icon = "";
            switch(type) {
                case "success":
                    toast.classList.add("bg-green-100","border","border-green-300","text-green-800");
                    icon = "✅";
                    break;
                case "error":
                    toast.classList.add("bg-red-100","border","border-red-300","text-red-800");
                    icon = "❌";
                    break;
                case "warning":
                    toast.classList.add("bg-yellow-100","border","border-yellow-300","text-yellow-800");
                    icon = "⚠️";
                    break;
                case "info":
                    toast.classList.add("bg-blue-100","border","border-blue-300","text-blue-800");
                    icon = "ℹ️";
                    break;
            }

            // ✅ محتوى الرسالة
            toast.innerHTML = `
                <span class="flex items-center gap-2 text-sm font-semibold flex-1">
                    ${icon} ${message}
                </span>
                <button class="ml-3 font-bold">✖</button>
            `;

            // إضافة للحاوية
            container.appendChild(toast);

            // إظهار بالحركة
            setTimeout(() => {
                toast.classList.remove("opacity-0","-translate-y-3");
                toast.classList.add("opacity-100","translate-y-0");
            }, 100);

            // إغلاق تلقائي بعد 5 ثواني
            const autoHide = setTimeout(() => hideToast(toast), 5000);

            // زر الإغلاق اليدوي
            toast.querySelector("button").addEventListener("click", () => {
                clearTimeout(autoHide);
                hideToast(toast);
            });
        };

        // ✅ وظيفة إخفاء وحذف التوست
        function hideToast(toast) {
            toast.classList.remove("opacity-100","translate-y-0");
            toast.classList.add("opacity-0","-translate-y-3");
            setTimeout(() => toast.remove(), 300);
        }

        // ✅ تشغيل أوتوماتيكي من الـ Session
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

