<?php if (isset($component)) { $__componentOriginal66d7cfd03cd343304d81fe1e21646540 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal66d7cfd03cd343304d81fe1e21646540 = $attributes; } ?>
<?php $component = App\View\Components\MainLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('main-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\MainLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="max-w-7xl mx-auto px-4 py-10">

        
        <div class="flex justify-center flex-wrap gap-4 mb-8">
            <a href="<?php echo e(route('ads.index', ['category' => 'عقارات'])); ?>"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow <?php if(request('category') == 'عقارات'): ?> bg-yellow-500 text-white <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                🏠 <span class="font-semibold">عقارات</span>
            </a>
            <a href="<?php echo e(route('ads.index', ['category' => 'سيارات'])); ?>"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow <?php if(request('category') == 'سيارات'): ?> bg-yellow-500 text-white <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                🚗 <span class="font-semibold">سيارات</span>
            </a>
            <a href="<?php echo e(route('ads.index', ['category' => 'خدمات'])); ?>"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow <?php if(request('category') == 'خدمات'): ?> bg-yellow-500 text-white <?php else: ?> bg-gray-100 text-gray-800 <?php endif; ?>">
                🛠️ <span class="font-semibold">خدمات</span>
            </a>
            <a href="<?php echo e(route('emergency.index')); ?>"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow bg-red-100 text-red-800 hover:bg-red-200">
                🆘 <span class="font-semibold">دلني عاجل</span>
            </a>
            <a href="<?php echo e(route('order.taxi')); ?>"
               class="flex items-center gap-2 px-5 py-2 rounded-full shadow bg-yellow-400 text-black font-bold hover:bg-yellow-500 transition">
                🚖 Delni Taxi
            </a>
        </div>

        
        <h1 class="text-3xl font-extrabold text-center text-yellow-600 mb-10">
            🗂️ <?php echo e(__('messages.all_ads')); ?>

        </h1>

        
        <form method="GET" action="<?php echo e(route('ads.index')); ?>" class="bg-white p-6 rounded-2xl shadow-md mb-12 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
            <div>
                <label for="city_text" class="block mb-2 text-sm font-semibold text-gray-700"><?php echo e(__('messages.search_city')); ?></label>
                <input type="text" name="city_text" id="city_text" dir="rtl" lang="ar"
                       value="<?php echo e(request('city_text')); ?>" placeholder="<?php echo e(__('messages.search_city')); ?>"
                       class="w-full rounded-xl border border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
            </div>

            
            <div>
                <label for="city" class="block mb-2 text-sm font-semibold text-gray-700"><?php echo e(__('messages.city')); ?></label>
                <select name="city" id="city" class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
                    <option value=""><?php echo e(__('messages.select_city')); ?></option>
                    <?php $__currentLoopData = ['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($city); ?>" <?php if(request('city') == $city): ?> selected <?php endif; ?>><?php echo e($city); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            
            <div>
                <label for="category" class="block mb-2 text-sm font-semibold text-gray-700"><?php echo e(__('messages.category')); ?></label>
                <select name="category" id="category" class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
                    <option value=""><?php echo e(__('messages.select_category')); ?></option>
                    <option value="عقارات" <?php if(request('category') == 'عقارات'): ?> selected <?php endif; ?>>عقارات</option>
                    <option value="سيارات" <?php if(request('category') == 'سيارات'): ?> selected <?php endif; ?>>سيارات</option>
                    <option value="خدمات" <?php if(request('category') == 'خدمات'): ?> selected <?php endif; ?>>خدمات</option>
                </select>
            </div>

            
            <div>
                <label for="min_price" class="block mb-2 text-sm font-semibold text-gray-700"><?php echo e(__('messages.min_price')); ?></label>
                <input type="number" name="min_price" id="min_price" value="<?php echo e(request('min_price')); ?>"
                       placeholder="مثلاً 100000"
                       class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
            </div>

            
            <div>
                <label for="max_price" class="block mb-2 text-sm font-semibold text-gray-700"><?php echo e(__('messages.max_price')); ?></label>
                <input type="number" name="max_price" id="max_price" value="<?php echo e(request('max_price')); ?>"
                       placeholder="مثلاً 500000"
                       class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
            </div>

            
            <div>
                <label for="is_featured" class="block mb-2 text-sm font-semibold text-gray-700">⭐ <?php echo e(__('messages.featured_only')); ?></label>
                <select name="is_featured" id="is_featured" class="w-full rounded-xl border-gray-300 p-3 text-right focus:ring-2 focus:ring-yellow-400">
                    <option value=""><?php echo e(__('messages.select_option')); ?></option>
                    <option value="1" <?php if(request('is_featured') === '1'): ?> selected <?php endif; ?>><?php echo e(__('messages.featured_only_yes')); ?></option>
                    <option value="0" <?php if(request('is_featured') === '0'): ?> selected <?php endif; ?>><?php echo e(__('messages.featured_only_no')); ?></option>
                </select>
            </div>

            
            <div class="col-span-full flex justify-end gap-4 pt-2">
                <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold px-6 py-3 rounded-xl shadow">
                    🔍 <?php echo e(__('messages.filter')); ?>

                </button>
                <a href="<?php echo e(route('ads.index')); ?>" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-6 py-3 rounded-xl shadow">
                    🔄 <?php echo e(__('messages.reset')); ?>

                </a>
            </div>
        </form>

        
        <?php if($ads->count()): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-8">
                <?php $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                        $firstImage = $images && count($images) > 0 ? $images[0] : null;
                    ?>

                    <a href="<?php echo e(route('ads.show', $ad->id)); ?>"
                       class="relative bg-white rounded-2xl shadow-md hover:shadow-xl transition overflow-hidden block group border-2 <?php echo e($ad->is_featured ? 'border-yellow-400' : 'border-gray-100'); ?>">

                        
                        <?php if($ad->is_featured): ?>
                            <div class="absolute top-0 right-0 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-bl">
                                ⭐ إعلان مميز
                            </div>
                        <?php endif; ?>

                        
                        <div class="relative">
                            <?php if($firstImage): ?>
                                <img src="<?php echo e(asset($firstImage)); ?>" alt="Ad Image"
                                     class="w-full h-48 object-cover group-hover:scale-105 transition duration-300">
                            <?php else: ?>
                                <img src="/placeholder.png" alt="No Image" class="w-full h-48 object-cover opacity-60">
                            <?php endif; ?>
                            <div class="absolute top-2 left-2 bg-white text-xs px-3 py-1 rounded shadow text-gray-700 font-semibold">
                                <?php echo e($ad->category); ?>

                            </div>
                        </div>

                        
                        <div class="p-4 space-y-1">
                            <h3 class="text-lg font-bold text-gray-800 truncate"><?php echo e($ad->title); ?></h3>
                            <p class="text-sm text-gray-600 truncate">📍 <?php echo e($ad->city); ?></p>
                            <p class="text-md font-bold text-yellow-600">💰 <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?></p>
                        </div>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            
            <div class="mt-10 text-center">
                <?php echo e($ads->links()); ?>

            </div>
        <?php else: ?>
            <p class="text-gray-600 text-center mt-10 text-lg"><?php echo e(__('messages.no_ads_found')); ?></p>
        <?php endif; ?>

    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal66d7cfd03cd343304d81fe1e21646540)): ?>
<?php $attributes = $__attributesOriginal66d7cfd03cd343304d81fe1e21646540; ?>
<?php unset($__attributesOriginal66d7cfd03cd343304d81fe1e21646540); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal66d7cfd03cd343304d81fe1e21646540)): ?>
<?php $component = $__componentOriginal66d7cfd03cd343304d81fe1e21646540; ?>
<?php unset($__componentOriginal66d7cfd03cd343304d81fe1e21646540); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/ads/index.blade.php ENDPATH**/ ?>