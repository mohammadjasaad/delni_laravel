<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $__env->yieldContent('title'); ?> - <?php echo e(config('app.name', 'Delni.co')); ?></title>

    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css']); ?>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">

    <div class="text-center max-w-md">
        <div class="mb-6">
            <img src="<?php echo e(asset('images/delnilogo.png')); ?>" alt="Delni Logo" class="w-20 h-20 mx-auto">
        </div>

        <h1 class="text-6xl font-bold text-yellow-600 mb-4"><?php echo $__env->yieldContent('code'); ?></h1>
        <p class="text-lg text-gray-700 mb-6"><?php echo $__env->yieldContent('message'); ?></p>

        <a href="<?php echo e(route('ads.index')); ?>"
           class="px-6 py-2 bg-yellow-500 hover:bg-yellow-600 text-white font-semibold rounded shadow">
            ⬅️ <?php echo e(__('messages.back_to_ads')); ?>

        </a>
    </div>

</body>
</html>
<?php /**PATH /home/delni_user/delni/resources/views/errors/layout.blade.php ENDPATH**/ ?>