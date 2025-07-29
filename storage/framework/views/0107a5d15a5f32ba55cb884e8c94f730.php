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
    <div class="max-w-6xl mx-auto py-10 px-4">

        <!-- 🧭 العنوان الرئيسي -->
        <h1 class="text-2xl font-bold mb-6 text-gray-800"><?php echo e(__('messages.my_ads')); ?></h1>

        <!-- 🔍 نموذج الفلترة -->
        <form method="GET" action="<?php echo e(route('dashboard.myads')); ?>" class="mb-6 flex flex-wrap gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700"><?php echo e(__('messages.city')); ?></label>
                <input type="text" name="city" value="<?php echo e(request('city')); ?>"
                       class="border border-gray-300 rounded px-3 py-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700"><?php echo e(__('messages.category')); ?></label>
                <input type="text" name="category" value="<?php echo e(request('category')); ?>"
                       class="border border-gray-300 rounded px-3 py-1">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700"><?php echo e(__('messages.featured_status')); ?></label>
                <select name="is_featured" class="border border-gray-300 rounded px-3 py-1">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="1" <?php echo e(request('is_featured') == '1' ? 'selected' : ''); ?>>⭐ <?php echo e(__('messages.featured_only')); ?></option>
                    <option value="0" <?php echo e(request('is_featured') === '0' ? 'selected' : ''); ?>><?php echo e(__('messages.normal_only')); ?></option>
                </select>
            </div>

            <div class="flex items-end gap-2">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1 rounded">
                    <?php echo e(__('messages.filter')); ?>

                </button>
                <a href="<?php echo e(route('dashboard.myads')); ?>" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-1 rounded">
                    <?php echo e(__('messages.reset')); ?>

                </a>
            </div>
        </form>

        <!-- 🖼️ عرض الإعلانات -->
        <?php if($ads->count() > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                        $firstImage = $images && count($images) > 0 ? $images[0] : null;
                    ?>

                    <div class="relative bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden border-2 <?php echo e($ad->is_featured ? 'border-yellow-400' : 'border-gray-100'); ?>">
                        
                        <!-- ⭐ شارة إعلان مميز -->
                        <?php if($ad->is_featured): ?>
                            <div class="absolute top-2 left-2 bg-yellow-400 text-white text-xs font-bold px-2 py-1 rounded shadow">
                                ⭐ <?php echo e(__('messages.featured_ad')); ?>

                            </div>
                        <?php endif; ?>

                        <!-- 🖼️ صورة الإعلان -->
                        <a href="<?php echo e(route('ads.show', $ad->id)); ?>">
                            <?php if($firstImage): ?>
                                <img src="<?php echo e(asset($firstImage)); ?>" alt="Ad Image" class="w-full h-48 object-cover">
                            <?php else: ?>
                                <img src="/placeholder.png" alt="No Image" class="w-full h-48 object-cover">
                            <?php endif; ?>

                            <div class="p-4 space-y-2">
                                <h2 class="text-lg font-semibold text-gray-800"><?php echo e($ad->title); ?></h2>
                                <p class="text-gray-600"><?php echo e(__('messages.price')); ?>: <?php echo e(number_format($ad->price)); ?></p>
                                <p class="text-gray-500 text-sm"><?php echo e(__('messages.city')); ?>: <?php echo e($ad->city); ?></p>
                                <p class="text-xs text-gray-400"><?php echo e($ad->created_at->diffForHumans()); ?></p>
                            </div>
                        </a>

                        <!-- 🛠️ أدوات التحكم -->
                        <div class="px-4 pb-4 flex flex-col gap-2">

                            <!-- ⭐ زر تمييز أو إزالة التمييز -->
                            <?php if($ad->is_featured): ?>
                                <form method="POST" action="<?php echo e(route('ads.unfeature', $ad->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="w-full bg-gray-300 hover:bg-gray-400 text-gray-800 px-3 py-1 rounded text-sm">
                                        ❌ <?php echo e(__('messages.unfeature_ad')); ?>

                                    </button>
                                </form>
                            <?php else: ?>
                                <form method="POST" action="<?php echo e(route('ads.feature', $ad->id)); ?>">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit"
                                            class="w-full bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm">
                                        ⭐ <?php echo e(__('messages.feature_ad')); ?>

                                    </button>
                                </form>
                            <?php endif; ?>

                            <!-- ✏️ زر تعديل -->
                            <a href="<?php echo e(route('dashboard.ads.edit', $ad->id)); ?>"
                               class="w-full text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                ✏️ <?php echo e(__('messages.edit')); ?>

                            </a>

                            <!-- 🗑️ زر حذف -->
                            <form method="POST" action="<?php echo e(route('dashboard.ads.destroy', $ad->id)); ?>"
                                  onsubmit="return confirm('<?php echo e(__('messages.confirm_delete')); ?>')">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit"
                                        class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                    🗑️ <?php echo e(__('messages.delete')); ?>

                                </button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <p class="text-gray-600 mt-6 text-center"><?php echo e(__('messages.no_ads_yet')); ?></p>
        <?php endif; ?>

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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/myads.blade.php ENDPATH**/ ?>