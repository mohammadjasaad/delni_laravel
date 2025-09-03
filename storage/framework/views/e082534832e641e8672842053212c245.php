
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<div class="max-w-5xl mx-auto px-4 py-8">

    
    <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-8 flex items-center gap-2">
        <i class="fas fa-user-circle text-yellow-500"></i> <?php echo e(__('messages.my_info')); ?>

    </h1>

    
    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-8 space-y-6 transition">

        
        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-user text-blue-500"></i> <?php echo e(__('messages.name')); ?>

            </span>
            <span class="text-gray-900 dark:text-white font-bold"><?php echo e(auth()->user()->name); ?></span>
        </div>

        
        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-envelope text-green-500"></i> <?php echo e(__('messages.email')); ?>

            </span>
            <span class="text-gray-900 dark:text-white font-bold"><?php echo e(auth()->user()->email); ?></span>
        </div>


<div class="flex items-center justify-between border-b border-gray-700 pb-2">
    <span class="flex items-center gap-2 text-gray-300">
        <i class="fas fa-phone text-yellow-400"></i> <?php echo e(__('messages.phone')); ?>

    </span>
    <span class="font-semibold text-white dark:text-gray-100">
        <?php echo e($user->phone ?? '-'); ?>

    </span>
</div>

        
        <div class="flex items-center justify-between border-b dark:border-gray-700 pb-4">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-calendar-alt text-purple-500"></i> <?php echo e(__('messages.registered_at')); ?>

            </span>
            <span class="text-gray-900 dark:text-white font-bold"><?php echo e(auth()->user()->created_at->format('Y-m-d')); ?></span>
        </div>

        
        <div class="flex items-center justify-between">
            <span class="flex items-center gap-2 text-lg font-semibold text-gray-700 dark:text-gray-300">
                <i class="fas fa-user-shield text-red-500"></i> <?php echo e(__('messages.role')); ?>

            </span>
            <span class="px-3 py-1 rounded-full text-sm font-bold 
                         <?php echo e(auth()->user()->role == 'admin' 
                            ? 'bg-red-100 text-red-600 dark:bg-red-700 dark:text-red-200' 
                            : 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300'); ?>">
                <?php echo e(auth()->user()->role == 'admin' ? __('messages.admin') : __('messages.user')); ?>

            </span>
        </div>
    </div>

    
    <div class="flex flex-wrap gap-3 mt-8">
        <a href="<?php echo e(route('dashboard.myinfo.edit')); ?>" 
           class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-lg shadow transition transform hover:scale-105">
            <i class="fas fa-edit"></i> <?php echo e(__('messages.edit_info')); ?>

        </a>
        <a href="<?php echo e(route('dashboard.password.change')); ?>" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded-lg shadow transition transform hover:scale-105">
            <i class="fas fa-key"></i> <?php echo e(__('messages.change_password')); ?>

        </a>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/myinfo.blade.php ENDPATH**/ ?>