
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
<div class="max-w-7xl mx-auto px-4 py-8">


<div class="flex flex-wrap items-center justify-center gap-3 mb-6">
    <a href="<?php echo e(route('ads.index', ['category' => 'realestate'])); ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       <?php echo e(request('category') == 'realestate' ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'); ?>">
        <i class="fas fa-building"></i> <?php echo e(__('messages.real_estate')); ?>

    </a>
    <a href="<?php echo e(route('ads.index', ['category' => 'cars'])); ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       <?php echo e(request('category') == 'cars' ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'); ?>">
        <i class="fas fa-car"></i> <?php echo e(__('messages.cars')); ?>

    </a>
    <a href="<?php echo e(route('ads.index', ['category' => 'services'])); ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       <?php echo e(request('category') == 'services' ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'); ?>">
        <i class="fas fa-tools"></i> <?php echo e(__('messages.services')); ?>

    </a>
    <a href="<?php echo e(route('delni.taxi')); ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       <?php echo e(request()->routeIs('delni.taxi') ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'); ?>">
        <i class="fas fa-taxi"></i> <?php echo e(__('messages.delni_taxi')); ?>

    </a>
    <a href="<?php echo e(route('emergency_services.index')); ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       <?php echo e(request()->routeIs('emergency_services.*') ? 'bg-yellow-400 text-black' : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'); ?>">
       <i class="fas fa-ambulance"></i> <?php echo e(__('messages.delni_emergency')); ?>

    </a>
</div>

    
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100">
            ❤️ <?php echo e(__('messages.favorites')); ?> (<?php echo e($favorites->total()); ?>)
        </h1>
        
        <button id="toggleView"
                class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg">
            <i class="fas fa-th-large"></i> / <i class="fas fa-list"></i> <?php echo e(__('messages.toggle_view')); ?>

        </button>
    </div>

    
    <form method="GET" action="<?php echo e(route('dashboard.favorites')); ?>" 
          class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 bg-white dark:bg-gray-800 shadow rounded-xl p-4">
        
        <select name="city" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value=""><?php echo e(__('messages.select_city')); ?></option>
            <?php $__currentLoopData = ['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($city); ?>" <?php echo e(request('city') == $city ? 'selected' : ''); ?>><?php echo e($city); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        
        <select name="category" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value=""><?php echo e(__('messages.select_category')); ?></option>
            <option value="realestate" <?php echo e(request('category') == 'realestate' ? 'selected' : ''); ?>>🏠 <?php echo e(__('messages.real_estate')); ?></option>
            <option value="cars" <?php echo e(request('category') == 'cars' ? 'selected' : ''); ?>>🚗 <?php echo e(__('messages.cars')); ?></option>
            <option value="services" <?php echo e(request('category') == 'services' ? 'selected' : ''); ?>>🛠️ <?php echo e(__('messages.services')); ?></option>
        </select>

        
        <select name="featured" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value=""><?php echo e(__('messages.featured_status')); ?></option>
            <option value="1" <?php echo e(request('featured') == '1' ? 'selected' : ''); ?>>⭐ <?php echo e(__('messages.featured')); ?></option>
            <option value="0" <?php echo e(request('featured') == '0' ? 'selected' : ''); ?>>⚪ <?php echo e(__('messages.normal')); ?></option>
        </select>

        
        <select name="sort" class="border rounded-lg p-2 dark:bg-gray-700 dark:text-gray-200">
            <option value=""><?php echo e(__('messages.sort_by')); ?></option>
            <option value="latest" <?php echo e(request('sort')=='latest'?'selected':''); ?>><?php echo e(__('messages.latest')); ?></option>
            <option value="price_desc" <?php echo e(request('sort')=='price_desc'?'selected':''); ?>><?php echo e(__('messages.price_high')); ?></option>
            <option value="price_asc" <?php echo e(request('sort')=='price_asc'?'selected':''); ?>><?php echo e(__('messages.price_low')); ?></option>
        </select>

        
        <div class="flex gap-2">
            <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg w-full">
                <i class="fas fa-search"></i> <?php echo e(__('messages.search')); ?>

            </button>
            <a href="<?php echo e(route('dashboard.favorites')); ?>" 
               class="bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 px-4 py-2 rounded-lg w-full text-center text-gray-800 dark:text-gray-200">
                <i class="fas fa-undo"></i> <?php echo e(__('messages.reset')); ?>

            </a>
        </div>
    </form>

    <?php if($favorites->count() > 0): ?>
        <div id="favoritesContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $favorites; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                    $firstImage = $images[0] ?? 'placeholder.png';
                ?>

                
                <div class="favorite-card grid-view relative bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-2xl transition overflow-hidden border <?php echo e($ad->is_featured ? 'border-yellow-400' : 'border-gray-200 dark:border-gray-700'); ?>">
                    
                    
                    <?php if($ad->is_featured): ?>
                        <div class="absolute top-2 left-2 bg-yellow-400 text-black text-xs font-bold px-2 py-1 rounded shadow">
                            ⭐ <?php echo e(__('messages.featured_ad')); ?>

                        </div>
                    <?php endif; ?>

                    
                    <a href="<?php echo e(route('ads.show', $ad->id)); ?>">
                        <img src="<?php echo e(asset('storage/' . $firstImage)); ?>" alt="Ad Image"
                             class="w-full h-48 object-cover">
                        <div class="p-4 space-y-2">
                            <h2 class="text-lg font-semibold text-gray-800 dark:text-white truncate">
                                <?php echo e($ad->title); ?>

                            </h2>
                            <p class="text-gray-600 dark:text-gray-300">
                                <i class="fas fa-dollar-sign"></i> <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?>

                            </p>
                            <p class="text-gray-500 dark:text-gray-400 text-sm">
                                <i class="fas fa-map-marker-alt"></i> <?php echo e($ad->city); ?>

                            </p>
                            <p class="text-xs text-gray-400 dark:text-gray-500">
                                <?php echo e($ad->created_at->diffForHumans()); ?>

                            </p>
                        </div>
                    </a>

                    
                    <div class="px-4 pb-4">
                        <form method="POST" action="<?php echo e(route('ads.unfavorite', $ad->id)); ?>">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm">
                                ❌ <?php echo e(__('messages.remove_favorite')); ?>

                            </button>
                        </form>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="mt-10">
            <?php echo e($favorites->links()); ?>

        </div>
    <?php else: ?>
        <p class="text-gray-600 dark:text-gray-400 mt-6 text-center">
            📌 <?php echo e(__('messages.no_favorites_yet')); ?>

        </p>
    <?php endif; ?>
</div>


<script>
    const favoritesContainer = document.getElementById('favoritesContainer');
    const toggleBtn = document.getElementById('toggleView');
    let currentView = "grid";

    function applyView() {
        document.querySelectorAll('.favorite-card').forEach(card => {
            if (currentView === 'grid') {
                card.classList.remove('list-view', 'flex');
                card.classList.add('grid-view', 'block');
            } else {
                card.classList.remove('grid-view', 'block');
                card.classList.add('list-view', 'flex');
            }
        });
    }

    applyView();

    toggleBtn.addEventListener('click', () => {
        currentView = (currentView === 'grid') ? 'list' : 'grid';
        applyView();
    });
</script>
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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/favorites.blade.php ENDPATH**/ ?>