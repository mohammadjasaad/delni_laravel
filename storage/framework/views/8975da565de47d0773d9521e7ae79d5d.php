<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title>Delni.co - تسجيل الدخول</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
</head>
<body class="font-sans antialiased bg-gray-900 text-gray-900">
    <div class="min-h-screen flex flex-col items-center justify-center">

        <!-- 🟡 شعار Delni.co -->
        <a href="/" class="flex justify-center mb-6">
            <img src="<?php echo e(asset('images/delnilogo.png')); ?>" 
                 alt="Delni.co"
                 class="w-28 h-28 rounded-full shadow-2xl border-4 border-yellow-400 bg-white p-1 transition-all duration-300 hover:scale-105 hover:shadow-yellow-300/40">
        </a>

        <!-- 🧱 صندوق تسجيل الدخول -->
        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-2xl rounded-2xl border-t-4 border-yellow-400">
            <?php echo e($slot); ?>

        </div>

        <!-- 🦶 فوتر -->
        <p class="mt-6 text-sm text-gray-400">
            © <?php echo e(date('Y')); ?> <span class="text-yellow-400 font-semibold">Delni.co</span> — جميع الحقوق محفوظة
        </p>
    </div>

    <style>
        /* ✨ حركة دخول ناعمة */
        @keyframes fade-in {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in {
            animation: fade-in 0.8s ease-in-out;
        }
    </style>
</body>
</html>
<?php /**PATH /home/delni_user/delni/resources/views/layouts/guest.blade.php ENDPATH**/ ?>