
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(__('mall.title'))]); ?>

    <div class="max-w-7xl mx-auto px-4 py-0 space-y-10">

<div class="w-full mb-2">
    <div class="relative w-full overflow-hidden rounded-xl shadow-lg">
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php if(isset($banners) && $banners->count()): ?>
                    <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="swiper-slide">
                            <a href="<?php echo e($banner->link ?? '#'); ?>">
                                <img src="<?php echo e(asset('storage/'.$banner->image_desktop)); ?>"
                                     alt="<?php echo e($banner->title); ?>"
                                     class="w-full h-48 md:h-72 object-cover">
                            </a>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    
                    <div class="swiper-slide">
                        <img src="<?php echo e(asset('images/banner1.jpg')); ?>" alt="Banner 1" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?php echo e(asset('images/banner2.jpg')); ?>" alt="Banner 2" class="w-full h-48 md:h-72 object-cover">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?php echo e(asset('images/banner3.jpg')); ?>" alt="Banner 3" class="w-full h-48 md:h-72 object-cover">
                    </div>
                <?php endif; ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
  new Swiper(".mySwiper", {
    pagination: { el: ".swiper-pagination", clickable: true },
    autoplay: { delay: 4000 },
    loop: true,
  });
</script>

        
<h1 class="text-3xl font-bold text-gray-800 dark:text-white mb-6 text-center">
    🛍️ <?php echo e(__('messages.delni_mall')); ?>

</h1>


<div class="text-center mb-6">
    <button id="toggleMallCategories" 
            class="px-6 py-2 bg-yellow-400 text-black rounded-full font-semibold hover:bg-yellow-500 transition">
<i class="fas fa-th-large"></i> <?php echo e(__('messages.mall_categories')); ?>

    </button>
</div>


<div id="mallCategories" class="hidden flex flex-wrap items-center justify-center gap-3 mb-6">
    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-laptop"></i> <?php echo e(__('mall.electronics')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-plug"></i> <?php echo e(__('mall.electricals')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-tshirt"></i> <?php echo e(__('mall.fashion')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-couch"></i> <?php echo e(__('mall.furniture')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-car"></i> <?php echo e(__('mall.cars')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-magic"></i> <?php echo e(__('mall.beauty')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-spray-can"></i> <?php echo e(__('mall.perfumes')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-book"></i> <?php echo e(__('mall.books')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-puzzle-piece"></i> <?php echo e(__('mall.toys')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-blender"></i> <?php echo e(__('mall.home_tools')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-shopping-basket"></i> <?php echo e(__('mall.supermarket')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-industry"></i> <?php echo e(__('mall.industrial')); ?>

    </a>

    <a href="#" class="px-5 py-2 rounded-full text-sm font-semibold transition
       bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600">
        <i class="fas fa-hard-hat"></i> <?php echo e(__('mall.construction')); ?>

    </a>
</div>

<script>
  document.getElementById("toggleMallCategories").addEventListener("click", function() {
    document.getElementById("mallCategories").classList.toggle("hidden");
  });
</script>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="store-card">
                    <a href="<?php echo e(route('mall.show', $store->id)); ?>">
                        <img src="<?php echo e($store->logo ? asset('storage/'.$store->logo) : asset('storage/placeholder.png')); ?>"
                             alt="<?php echo e($store->name); ?>">
                        <h3><?php echo e($store->name); ?></h3>
                        <p><?php echo e(Str::limit($store->description, 60)); ?></p>
                    </a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="mt-6">
            <?php echo e($stores->links()); ?>

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
<?php /**PATH /home/delni_user/delni/resources/views/mall/index.blade.php ENDPATH**/ ?>