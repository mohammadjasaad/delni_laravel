
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
        <a href="<?php echo e(route('ads.index', ['category' => 'realestate'])); ?>" class="tab-link <?php echo e(request('category')=='realestate' ? 'active':''); ?>">
            <i class="fas fa-building"></i> <?php echo e(__('messages.real_estate')); ?>

        </a>
        <a href="<?php echo e(route('ads.index', ['category' => 'cars'])); ?>" class="tab-link <?php echo e(request('category')=='cars' ? 'active':''); ?>">
            <i class="fas fa-car"></i> <?php echo e(__('messages.cars')); ?>

        </a>
        <a href="<?php echo e(route('ads.index', ['category' => 'services'])); ?>" class="tab-link <?php echo e(request('category')=='services' ? 'active':''); ?>">
            <i class="fas fa-tools"></i> <?php echo e(__('messages.services')); ?>

        </a>
        <a href="<?php echo e(route('delni.taxi')); ?>" class="tab-link <?php echo e(request()->routeIs('delni.taxi') ? 'active':''); ?>">
            <i class="fas fa-taxi"></i> <?php echo e(__('messages.delni_taxi')); ?>

        </a>
        <a href="<?php echo e(route('emergency_services.index')); ?>" class="tab-link <?php echo e(request()->routeIs('emergency_services.*') ? 'active':''); ?>">
            <i class="fas fa-ambulance"></i> <?php echo e(__('messages.delni_emergency')); ?>

        </a>
    </div>

    
    <h1 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-4 flex items-center gap-2">
        <i class="fas fa-bullhorn text-yellow-500"></i> <?php echo e(__('messages.my_ads')); ?> (<?php echo e($ads->total()); ?>)
    </h1>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
        <div class="stat-card bg-yellow-100 dark:bg-yellow-600">
            <i class="fas fa-list text-yellow-600 dark:text-yellow-200 text-xl"></i>
            <h3><?php echo e(__('messages.total_ads')); ?></h3>
            <p><?php echo e($ads->total()); ?></p>
        </div>
        <div class="stat-card bg-yellow-200 dark:bg-yellow-700">
            <i class="fas fa-star text-yellow-700 dark:text-yellow-300 text-xl"></i>
            <h3><?php echo e(__('messages.featured')); ?></h3>
            <p><?php echo e($featuredCount ?? 0); ?></p>
        </div>
        <div class="stat-card bg-gray-200 dark:bg-gray-700">
            <i class="fas fa-circle text-gray-600 dark:text-gray-300 text-xl"></i>
            <h3><?php echo e(__('messages.normal')); ?></h3>
            <p><?php echo e($normalCount ?? 0); ?></p>
        </div>
    </div>

    
    <div class="flex flex-wrap items-center gap-3 mb-6">
        <a href="<?php echo e(route('dashboard.myads', ['featured' => 1])); ?>" class="sub-tab <?php echo e(request('featured')==='1' ? 'active':''); ?>">
            <i class="fas fa-star text-yellow-500"></i> <?php echo e(__('messages.my_featured_ads')); ?>

        </a>
        <a href="<?php echo e(route('dashboard.myads', ['featured' => 0])); ?>" class="sub-tab <?php echo e(request('featured')==='0' ? 'active':''); ?>">
            <i class="fas fa-circle text-gray-500"></i> <?php echo e(__('messages.my_normal_ads')); ?>

        </a>
        <a href="<?php echo e(route('dashboard.myads')); ?>" class="sub-tab <?php echo e(request('featured')=='' ? 'active':''); ?>">
            <i class="fas fa-list"></i> <?php echo e(__('messages.all')); ?>

        </a>
    </div>

    
    <form method="GET" action="<?php echo e(route('dashboard.myads')); ?>" 
          class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-6 bg-white dark:bg-gray-800 shadow rounded-xl p-4">

        <select name="city" class="input">
            <option value=""><?php echo e(__('messages.select_city')); ?></option>
            <?php $__currentLoopData = ['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','السويداء','درعا','القنيطرة','إدلب','الرقة','دير الزور','الحسكة']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($city); ?>" <?php echo e(request('city')==$city ? 'selected':''); ?>><?php echo e($city); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>

        <select name="category" class="input">
            <option value=""><?php echo e(__('messages.select_category')); ?></option>
            <option value="realestate" <?php echo e(request('category')=='realestate' ? 'selected':''); ?>><?php echo e(__('messages.real_estate')); ?></option>
            <option value="cars" <?php echo e(request('category')=='cars' ? 'selected':''); ?>><?php echo e(__('messages.cars')); ?></option>
            <option value="services" <?php echo e(request('category')=='services' ? 'selected':''); ?>><?php echo e(__('messages.services')); ?></option>
        </select>

        <select name="featured" class="input">
            <option value=""><?php echo e(__('messages.featured_status')); ?></option>
            <option value="1" <?php echo e(request('featured')=='1' ? 'selected':''); ?>>⭐ <?php echo e(__('messages.featured')); ?></option>
            <option value="0" <?php echo e(request('featured')=='0' ? 'selected':''); ?>>⚪ <?php echo e(__('messages.normal')); ?></option>
        </select>

        <select name="sort" class="input">
            <option value=""><?php echo e(__('messages.sort_by')); ?></option>
            <option value="latest" <?php echo e(request('sort')=='latest'?'selected':''); ?>><?php echo e(__('messages.latest')); ?></option>
            <option value="price_desc" <?php echo e(request('sort')=='price_desc'?'selected':''); ?>><?php echo e(__('messages.price_high')); ?></option>
            <option value="price_asc" <?php echo e(request('sort')=='price_asc'?'selected':''); ?>><?php echo e(__('messages.price_low')); ?></option>
        </select>

        <div class="flex gap-2">
            <button type="submit" class="btn-yellow w-full">
                <i class="fas fa-search"></i> <?php echo e(__('messages.search')); ?>

            </button>
            <a href="<?php echo e(route('dashboard.myads')); ?>" class="btn-gray w-full">
                <i class="fas fa-undo"></i> <?php echo e(__('messages.reset')); ?>

            </a>
        </div>
    </form>

    
    <div class="flex justify-end mb-4">
        <button id="toggleView" class="btn-yellow">
            <i class="fas fa-th-large"></i> / <i class="fas fa-list"></i> <?php echo e(__('messages.toggle_view')); ?>

        </button>
    </div>

    
    <div id="adsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
                $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
                $firstImage = $images[0] ?? 'placeholder.png';
            ?>

            
            <div class="ad-card <?php echo e($ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700'); ?>">
                <?php if($ad->is_featured): ?>
                    <span class="badge-featured"><i class="fas fa-star"></i></span>
                <?php endif; ?>

                
                <a href="<?php echo e(route('ads.show', $ad->id)); ?>">
                    <img src="<?php echo e(asset('storage/'.$firstImage)); ?>" 
                         onerror="this.onerror=null;this.src='<?php echo e(asset('storage/placeholder.png')); ?>';"
                         class="w-full h-40 object-cover rounded-t-xl" alt="ad">
                </a>

                
                <div class="p-4 flex flex-col justify-between flex-1 content">
                    <div>
                        <h2 class="font-bold text-base truncate text-gray-900 dark:text-white"><?php echo e($ad->title); ?></h2>
                        <p class="text-gray-500 dark:text-gray-400 text-sm">
                            <i class="fas fa-map-marker-alt text-red-500"></i> <?php echo e($ad->city); ?>

                        </p>
                        <p class="price">
                            <i class="fas fa-dollar-sign"></i> <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?>

                        </p>
                    </div>

                    
                    <div class="flex flex-wrap justify-between mt-3 gap-2 actions">
                        <a href="<?php echo e(route('dashboard.ads.edit', $ad->id)); ?>" class="btn-blue">
                            <i class="fas fa-edit"></i> <?php echo e(__('messages.edit')); ?>

                        </a>
                        <form action="<?php echo e(route('dashboard.ads.destroy', $ad->id)); ?>" method="POST" onsubmit="return confirm('<?php echo e(__('messages.confirm_delete')); ?>');">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn-red">
                                <i class="fas fa-trash"></i> <?php echo e(__('messages.delete')); ?>

                            </button>
                        </form>
                        <?php if(!$ad->is_featured): ?>
                            <a href="<?php echo e(route('dashboard.ads.feature', $ad->id)); ?>" class="btn-yellow">
                                <i class="fas fa-star"></i> <?php echo e(__('messages.make_featured')); ?>

                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('dashboard.ads.unfeature', $ad->id)); ?>" class="btn-gray">
                                <i class="fas fa-ban"></i> <?php echo e(__('messages.remove_featured')); ?>

                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-center col-span-4 text-gray-500 dark:text-gray-400 mt-8">
                <i class="fas fa-exclamation-circle"></i> <?php echo e(__('messages.no_ads_found')); ?>

            </p>
        <?php endif; ?>
    </div>

    
    <div class="mt-10"><?php echo e($ads->links()); ?></div>
</div>


<script>
    const toggleBtn = document.getElementById('toggleView');
    let currentView = "<?php echo e(auth()->user()->ads_view ?? 'grid'); ?>"; 

    function applyView() {
        document.querySelectorAll('.ad-card').forEach(card => {
            if (currentView === 'grid') {
                card.classList.remove('list-view');
                card.classList.add('grid-view');
            } else {
                card.classList.remove('grid-view');
                card.classList.add('list-view');
            }
        });
    }

    applyView();

    toggleBtn.addEventListener('click', () => {
        currentView = (currentView === 'grid') ? 'list':'grid';
        applyView();

        fetch("<?php echo e(route('dashboard.saveView')); ?>", {
            method:"POST",
            headers:{
                "X-CSRF-TOKEN":"<?php echo e(csrf_token()); ?>",
                "Content-Type":"application/json"
            },
            body: JSON.stringify({ view: currentView })
        });
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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/myads.blade.php ENDPATH**/ ?>