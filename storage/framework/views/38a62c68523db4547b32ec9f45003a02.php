<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<!-- ✅ Lightbox2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title', 'Delni.co'); ?></title>

    <!-- ✅ خط Cairo -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">

    <!-- ✅ ستايلات -->
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>

    <!-- ✅ إضافة AlpineJS -->
    <script src="//unpkg.com/alpinejs" defer></script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex flex-col min-h-screen">

    
    <?php echo $__env->make('partials.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <main class="flex-1 py-8">
        <?php if(isset($slot)): ?>
            <?php echo e($slot); ?>

        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo app('Illuminate\Foundation\Vite')(['resources/js/app.js']); ?>
<!-- ✅ Lightbox2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    function toggleDarkMode() {
        document.documentElement.classList.toggle('dark');
        localStorage.setItem('darkMode', document.documentElement.classList.contains('dark') ? 'enabled' : 'disabled');
        updateIcons();
    }

    function updateIcons() {
        const isDark = document.documentElement.classList.contains('dark');
        const desktopBtn = document.getElementById("toggleDarkModeDesktop");
        const mobileBtn = document.getElementById("toggleDarkModeMobile");
        if (desktopBtn) desktopBtn.textContent = isDark ? "☀️" : "🌙";
        if (mobileBtn) mobileBtn.textContent = isDark ? "☀️" : "🌙";
    }

    const desktopBtn = document.getElementById("toggleDarkModeDesktop");
    const mobileBtn = document.getElementById("toggleDarkModeMobile");

    if (desktopBtn) desktopBtn.addEventListener("click", toggleDarkMode);
    if (mobileBtn) mobileBtn.addEventListener("click", toggleDarkMode);

    if (localStorage.getItem('darkMode') === 'enabled') {
        document.documentElement.classList.add('dark');
    }
    updateIcons();
});
</script>
</body>
</html>
<?php /**PATH /home/delni_user/delni/resources/views/layouts/app.blade.php ENDPATH**/ ?>