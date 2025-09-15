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
<div class="max-w-6xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold mb-6">
        🧑 <?php echo e($user->name); ?> - <?php echo e(__('messages.ads')); ?>

    </h1>

    
    <div class="bg-white shadow rounded-xl p-6 flex items-center gap-4 mb-8">
<img src="<?php echo e($user->avatar ? asset('storage/'.$user->avatar) : asset('images/default-user.png')); ?>" 
     alt="avatar" class="w-12 h-12 rounded-full object-cover border">
        <div>
            <h2 class="font-bold text-lg"><?php echo e($user->name); ?></h2>
            <p class="text-gray-600"><i class="fas fa-phone text-green-500"></i> <?php echo e($user->phone ?? 'غير متوفر'); ?></p>
            <p class="text-sm text-gray-500">📢 <?php echo e($user->ads()->count()); ?> <?php echo e(__('messages.ads')); ?></p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $imgs = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                $img  = !empty($imgs[0]) ? asset('storage/'.$imgs[0]) : asset('storage/placeholder.png');
            ?>
            <a href="<?php echo e(route('ads.show', $ad->id)); ?>" class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                <img src="<?php echo e($img); ?>" class="w-full h-40 object-cover" alt="ad">
                <div class="p-3">
                    <h3 class="font-bold truncate"><?php echo e($ad->title); ?></h3>
                    <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt"></i> <?php echo e($ad->city); ?></p>
                    <p class="text-red-600 font-bold text-sm"><i class="fas fa-dollar-sign"></i> <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?></p>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500">🚫 <?php echo e(__('messages.no_ads_found')); ?></p>
        <?php endif; ?>
    </div>

    <div class="mt-6">
        <?php echo e($ads->links()); ?>

    </div>
</div>
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
<?php /**PATH /home/delni_user/delni/resources/views/users/ads.blade.php ENDPATH**/ ?>