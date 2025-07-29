<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title><?php echo e(__('messages.contact_us')); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto py-12 px-6 bg-white shadow rounded mt-10">

        <h1 class="text-3xl font-bold text-center mb-8 text-yellow-500">
            <?php echo e(__('messages.contact_us')); ?>

        </h1>

        <!-- ✅ عرض رسالة النجاح -->
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-700 p-4 rounded mb-6 text-sm text-center">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('contact.send')); ?>" method="POST">
            <?php echo csrf_field(); ?>

            <!-- الاسم -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700"><?php echo e(__('messages.name')); ?></label>
                <input id="name" type="text" name="name" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
            </div>

            <!-- البريد الإلكتروني -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700"><?php echo e(__('messages.email')); ?></label>
                <input id="email" type="email" name="email" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500">
            </div>

            <!-- الرسالة -->
            <div class="mb-6">
                <label for="message" class="block text-sm font-medium text-gray-700"><?php echo e(__('messages.message')); ?></label>
                <textarea id="message" name="message" rows="5" required class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:ring-yellow-500 focus:border-yellow-500"></textarea>
            </div>

            <!-- زر الإرسال -->
            <div class="text-center">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded">
                    <?php echo e(__('messages.send_message')); ?>

                </button>
            </div>
        </form>
<div class="mt-6 text-center">
    <a href="<?php echo e(route('home')); ?>" class="inline-block bg-gray-200 text-gray-800 px-4 py-2 rounded hover:bg-gray-300 transition">
        🔙 العودة إلى الرئيسية
    </a>
</div>

    </div>
</body>
</html>
<?php /**PATH /home/delni_user/delni/resources/views/contact.blade.php ENDPATH**/ ?>