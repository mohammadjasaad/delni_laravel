
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
<div class="max-w-7xl mx-auto px-4 py-10">

    
    <div class="flex items-center justify-between mb-10">
        <h1 class="text-3xl font-bold text-gray-800 dark:text-gray-100">
            <i class="fas fa-tachometer-alt text-yellow-500"></i> <?php echo e(__('messages.dashboard')); ?>

        </h1>
    </div>

    
    <h2 class="text-xl font-bold mb-4 text-gray-700 dark:text-gray-200">📊 <?php echo e(__('messages.quick_stats')); ?></h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-6 mb-10">

        
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-bullhorn text-yellow-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><?php echo e($myAdsCount ?? 0); ?></h2>
            <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('messages.my_ads')); ?></p>
        </div>

        
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-star text-yellow-400 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><?php echo e($featuredAdsCount ?? 0); ?></h2>
            <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('messages.featured')); ?></p>
        </div>

        
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-circle text-gray-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><?php echo e($normalAdsCount ?? 0); ?></h2>
            <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('messages.normal')); ?></p>
        </div>

        
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-heart text-pink-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><?php echo e($favoritesCount ?? 0); ?></h2>
            <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('messages.favorites')); ?></p>
        </div>

        
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-taxi text-green-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><?php echo e($ordersCount ?? 0); ?></h2>
            <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('messages.my_orders')); ?></p>
        </div>

        
        <div class="bg-white dark:bg-gray-800 shadow rounded-2xl p-6 text-center hover:shadow-lg transition">
            <i class="fas fa-ambulance text-red-500 text-3xl mb-3"></i>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-gray-100"><?php echo e($emergencyReportsCount ?? 0); ?></h2>
            <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('messages.delni_emergency')); ?></p>
        </div>
    </div>

    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

        
        <a href="<?php echo e(route('dashboard.myads')); ?>" 
           class="bg-gradient-to-r from-yellow-400 to-yellow-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-bullhorn text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.my_ads')); ?></h2>
            <p class="text-sm opacity-90 mt-1"><?php echo e(__('messages.manage_my_ads')); ?></p>
        </a>

        
        <a href="<?php echo e(route('ads.create')); ?>" 
           class="bg-gradient-to-r from-green-400 to-green-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-plus-circle text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.add_ad')); ?></h2>
            <p class="text-sm opacity-90 mt-1">✏️ <?php echo e(__('messages.add_new_ad')); ?></p>
        </a>

        
        <a href="<?php echo e(route('dashboard.favorites')); ?>" 
           class="bg-gradient-to-r from-pink-400 to-pink-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-heart text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.favorites')); ?></h2>
            <p class="text-sm opacity-90 mt-1">❤️ <?php echo e(__('messages.favorite_ads')); ?></p>
        </a>

        
        <a href="<?php echo e(route('dashboard.myorders')); ?>" 
           class="bg-gradient-to-r from-green-400 to-green-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-taxi text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.my_orders')); ?></h2>
            <p class="text-sm opacity-90 mt-1">🚖 <?php echo e(__('messages.track_orders')); ?></p>
        </a>

        
          <a href="<?php echo e(route('emergency_services.index')); ?>"
           class="bg-gradient-to-r from-red-400 to-red-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-ambulance text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.delni_emergency')); ?></h2>
            <p class="text-sm opacity-90 mt-1">🚨 <?php echo e(__('messages.emergency_centers')); ?></p>
        </a>

        
        <a href="<?php echo e(route('dashboard.myinfo')); ?>" 
           class="bg-gradient-to-r from-blue-400 to-blue-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-user-circle text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.my_info')); ?></h2>
            <p class="text-sm opacity-90 mt-1">👤 <?php echo e(__('messages.account_info')); ?></p>
        </a>

        
        <a href="<?php echo e(route('dashboard.password.change')); ?>" 
           class="bg-gradient-to-r from-purple-400 to-purple-500 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-key text-3xl mb-4"></i>
            <h2 class="text-xl font-bold"><?php echo e(__('messages.change_password')); ?></h2>
            <p class="text-sm opacity-90 mt-1">🔑 <?php echo e(__('messages.update_password')); ?></p>
        </a>

        
        <?php if(auth()->user()->role === 'admin'): ?>
        <a href="<?php echo e(route('admin.emergency_reports.index')); ?>" 
           class="bg-gradient-to-r from-gray-600 to-gray-700 rounded-2xl shadow-lg p-6 text-white hover:scale-105 hover:shadow-xl transition transform">
            <i class="fas fa-exclamation-triangle text-3xl mb-4"></i>
            <h2 class="text-xl font-bold">إدارة البلاغات</h2>
            <p class="text-sm opacity-90 mt-1">🛠️ لوحة المشرف</p>
        </a>
        <?php endif; ?>
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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/index.blade.php ENDPATH**/ ?>