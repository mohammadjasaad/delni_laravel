
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($store->name)]); ?>
    <div class="max-w-7xl mx-auto px-4 py-10 space-y-10">

        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-center md:items-start gap-6 p-6">
                
                <img src="<?php echo e($store->logo ? asset('storage/'.$store->logo) : asset('storage/placeholder.png')); ?>"
                     alt="<?php echo e($store->name); ?>"
                     class="w-32 h-32 rounded-full border border-gray-200 dark:border-gray-700 object-cover shadow-lg group-hover:scale-105 transition">

                
                <div class="flex-1 space-y-3">
                    <h1 class="text-3xl font-bold text-gray-900 dark:text-white">
                        <?php echo e($store->name); ?>

                    </h1>
                    <p class="text-gray-600 dark:text-gray-300 leading-relaxed">
                        <?php echo e($store->description ?? __('mall.no_description_available')); ?>

                    </p>

                    <div class="flex flex-wrap items-center gap-3">
                        <span class="px-4 py-1 text-sm bg-yellow-100 text-yellow-700 rounded-full">
                            📂 <?php echo e(__('mall.' . $store->category)); ?>

                        </span>
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="fas fa-calendar-alt text-yellow-500"></i>
                            <?php echo e(__('mall.created_at')); ?>: <?php echo e($store->created_at->format('Y-m-d')); ?>

                        </span>
                    </div>
                </div>

                
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->id() === $store->user_id): ?>
                        <div class="flex flex-col gap-2">
                            <a href="<?php echo e(route('mall.edit', $store->id)); ?>" class="btn-yellow flex items-center gap-2">
                                ✏️ <?php echo e(__('mall.edit_store')); ?>

                            </a>
                            <form action="<?php echo e(route('mall.destroy', $store->id)); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        onclick="return confirm('<?php echo e(__('mall.confirm_delete')); ?>')"
                                        class="btn-red flex items-center gap-2">
                                    🗑️ <?php echo e(__('mall.delete')); ?>

                                </button>
                            </form>

                            
                            <a href="<?php echo e(route('mall.dashboard', $store->id)); ?>" 
                               class="btn-blue flex items-center gap-2">
                               ⚙️ <?php echo e(__('mall.dashboard')); ?>

                            </a>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>

        
        <div>
            <h2 class="section-title">📦 <?php echo e(__('mall.store_products')); ?></h2>

            <?php if($store->products->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $store->products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ad-card group">
                            <a href="<?php echo e(route('mall.products.show', [$store->id, $product->id])); ?>">
                                <img src="<?php echo e($product->image ? asset('storage/'.$product->image) : asset('images/no-image.png')); ?>"
                                     alt="<?php echo e($product->name); ?>"
                                     class="w-full h-40 object-cover rounded-t-xl group-hover:opacity-90 transition">
                            </a>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">
                                    <?php echo e($product->name); ?>

                                </h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400 line-clamp-2">
                                    <?php echo e($product->description); ?>

                                </p>
                                <span class="price"><?php echo e($product->price); ?> <?php echo e(__('mall.currency')); ?></span>
                                <a href="<?php echo e(route('mall.products.show', [$store->id, $product->id])); ?>"
                                   class="btn-blue mt-2">
                                    👁️ <?php echo e(__('mall.view')); ?>

                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('mall.no_products')); ?></p>
            <?php endif; ?>
        </div>

        
        <div>
            <h2 class="section-title">📢 <?php echo e(__('mall.ads')); ?></h2>

            <?php if($store->ads->count()): ?>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    <?php $__currentLoopData = $store->ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="ad-card group relative">
                            <?php if($ad->is_featured): ?>
                                <span class="badge-featured">⭐ <?php echo e(__('mall.featured')); ?></span>
                            <?php endif; ?>
                            <a href="<?php echo e(route('mall.ads.show', [$store->id, $ad->id])); ?>">
                                <img src="<?php echo e(!empty($ad->images) && is_array($ad->images) && isset($ad->images[0]) 
                                    ? asset('storage/'.$ad->images[0]) 
                                    : asset('images/no-image.png')); ?>"
                                     alt="<?php echo e($ad->title); ?>"
                                     class="w-full h-40 object-cover rounded-t-xl group-hover:opacity-90 transition">
                            </a>
                            <div class="p-4 space-y-2">
                                <h3 class="font-bold text-lg text-gray-800 dark:text-white truncate">
                                    <?php echo e($ad->title); ?>

                                </h3>
                                <span class="price"><?php echo e($ad->price); ?> <?php echo e(__('mall.currency')); ?></span>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    🌍 <?php echo e($ad->city); ?> | 📂 <?php echo e(__('mall.' . $ad->category)); ?>

                                </p>
                                <a href="<?php echo e(route('mall.ads.show', [$store->id, $ad->id])); ?>"
                                   class="btn-yellow mt-2">
                                    👁️ <?php echo e(__('mall.view')); ?>

                                </a>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php else: ?>
                <p class="text-gray-500 dark:text-gray-400"><?php echo e(__('mall.no_ads')); ?></p>
            <?php endif; ?>
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

<?php /**PATH /home/delni_user/delni/resources/views/mall/show.blade.php ENDPATH**/ ?>