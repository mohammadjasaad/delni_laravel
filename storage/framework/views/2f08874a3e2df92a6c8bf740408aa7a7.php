

<div class="flex items-center justify-between px-6 py-4 bg-white shadow">

    
    <div class="flex items-center space-x-3 rtl:space-x-reverse">
        <img
            src="<?php echo e(asset('images/delnilogo.png')); ?>"
            alt="Delni Logo"
            class="<?php echo e(request()->routeIs('about') ? 'h-4' : 'h-9'); ?>"
        >
        <span class="text-xl font-bold text-gray-800">Delni.co</span>
    </div>

    
    <nav class="space-x-6 rtl:space-x-reverse text-sm font-semibold">
        <a href="<?php echo e(route('home')); ?>" class="text-gray-700 hover:text-yellow-600"><?php echo e(__('messages.home')); ?></a>
        <a href="<?php echo e(route('ads.index')); ?>" class="text-gray-700 hover:text-yellow-600"><?php echo e(__('messages.ads')); ?></a>
        <a href="<?php echo e(route('about')); ?>" class="text-gray-700 hover:text-yellow-600"><?php echo e(__('messages.about')); ?></a>
        <a href="<?php echo e(route('contact')); ?>" class="text-gray-700 hover:text-yellow-600"><?php echo e(__('messages.contact')); ?></a>
        <a href="<?php echo e(route('drivers.map')); ?>" class="text-gray-700 hover:text-yellow-600"><?php echo e(__('messages.drivers_map')); ?></a>

        
        <a href="<?php echo e(route('delni.taxi')); ?>"
           class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-full shadow">
            🚖 Delni Taxi
        </a>
    </nav>

    
    <?php if(auth()->guard()->check()): ?>
        <div>
            <a href="<?php echo e(route('dashboard.index')); ?>" class="bg-yellow-500 text-white px-4 py-2 rounded shadow">
                <?php echo e(__('messages.my_account')); ?>

            </a>
        </div>
    <?php endif; ?>

</div>
<?php /**PATH /home/delni_user/delni/resources/views/layouts/partials/header.blade.php ENDPATH**/ ?>