<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="flex justify-center items-center min-h-screen bg-gray-100 px-4">
        <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-xl border border-gray-200 text-center">

            <!-- 🖼️ شعار -->
            <div class="flex justify-center mb-6">
                <img src="<?php echo e(asset('images/delnilogo.png')); ?>" alt="Delni Logo" class="w-24 h-24">
            </div>

            <!-- ✅ العنوان -->
            <h1 class="text-3xl font-extrabold text-gray-800 mb-4">
                ✅ <?php echo e(__('messages.logged_out')); ?>

            </h1>

            <!-- 📝 الوصف -->
            <p class="text-gray-600 text-sm mb-6 leading-relaxed">
                <?php echo e(__('messages.logged_out_message')); ?>

            </p>

            <!-- 🔘 الأزرار جنب بعض -->
            <div class="flex gap-3">
                <!-- زر العودة لتسجيل الدخول -->
                <a href="<?php echo e(route('login')); ?>" 
                   class="flex-1 bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition text-center">
                    🔙 <?php echo e(__('messages.back_to_login')); ?>

                </a>

                <!-- زر العودة للرئيسية -->
                <a href="<?php echo e(route('home')); ?>" 
                   class="flex-1 bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-3 px-6 rounded-lg shadow-md transition text-center">
                    🏠 <?php echo e(__('messages.back_to_home')); ?>

                </a>
            </div>
        </div>
    </div>

    <!-- 🟢 Toast Notification (ديناميكي) -->
    <div id="toastAlert" 
         class="fixed top-4 left-1/2 transform -translate-x-1/2 opacity-0 translate-y-[-20px] transition duration-700 ease-out 
                flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg z-50">
        <span id="toastIcon" class="text-2xl"></span>
        <span id="toastMessage" class="text-sm font-semibold flex-1"></span>
        <button id="closeToast" class="text-lg font-bold hover:text-red-600">❌</button>
    </div>

    <!-- 🎬 سكربت Animation + أنواع التوست -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toast = document.getElementById("toastAlert");
            const toastIcon = document.getElementById("toastIcon");
            const toastMessage = document.getElementById("toastMessage");
            const closeBtn = document.getElementById("closeToast");

            // 🟢 أنواع التوست: success | error | warning | info
            function showToast(type = "success", message = "✅ Logged out successfully!") {
                // Reset classes
                toast.className = "fixed top-4 left-1/2 transform -translate-x-1/2 opacity-0 translate-y-[-20px] transition duration-700 ease-out flex items-center gap-3 px-5 py-3 rounded-lg shadow-lg z-50";

                switch(type) {
                    case "success":
                        toast.classList.add("bg-green-100", "border", "border-green-300", "text-green-800");
                        toastIcon.textContent = "✅";
                        break;
                    case "error":
                        toast.classList.add("bg-red-100", "border", "border-red-300", "text-red-800");
                        toastIcon.textContent = "❌";
                        break;
                    case "warning":
                        toast.classList.add("bg-yellow-100", "border", "border-yellow-300", "text-yellow-800");
                        toastIcon.textContent = "⚠️";
                        break;
                    case "info":
                        toast.classList.add("bg-blue-100", "border", "border-blue-300", "text-blue-800");
                        toastIcon.textContent = "ℹ️";
                        break;
                }

                // Set message
                toastMessage.textContent = message;

                // Show
                setTimeout(() => {
                    toast.classList.remove("opacity-0", "translate-y-[-20px]");
                    toast.classList.add("opacity-100", "translate-y-0");
                }, 200);

                // Auto hide
                const autoHide = setTimeout(() => {
                    hideToast();
                }, 5000);

                // Close button
                closeBtn.addEventListener("click", () => {
                    clearTimeout(autoHide);
                    hideToast();
                });
            }

            function hideToast() {
                toast.classList.remove("opacity-100", "translate-y-0");
                toast.classList.add("opacity-0", "translate-y-[-20px]");
            }

            // ✅ عرض Toast عند تسجيل الخروج
            showToast("success", "<?php echo e(__('messages.logout_success') ?? 'You have successfully logged out.'); ?>");
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/auth/logged-out.blade.php ENDPATH**/ ?>