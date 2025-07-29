<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Delni.co')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;800&display=swap">
    
    <!-- Styles -->
    <?php echo app('Illuminate\Foundation\Vite')('resources/css/app.css'); ?>

    <style>
        body {
            font-family: 'Cairo', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    
    <div class="bg-yellow-100 text-center py-2 text-sm text-yellow-900 font-semibold">
        🚧 هذا الموقع في نسخته التجريبية - نعمل على تطويره وتحسينه يومياً. شكراً لدعمكم ❤️
    </div>

    
    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <main class="py-8">
        <?php echo e($slot); ?>

    </main>

</body>
</html>
<?php /**PATH /home/delni_user/delni/resources/views/layouts/app.blade.php ENDPATH**/ ?>