
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



<div class="flex justify-center gap-3 mb-8">

    <?php if(auth()->check()): ?>
        <?php if(auth()->user()->store): ?>
            <a href="<?php echo e(route('mall.dashboard', auth()->user()->store->id)); ?>"
               class="flex items-center gap-2 px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-full font-semibold shadow transition">
                🏪 متجري
            </a>
        <?php else: ?>
            <a href="<?php echo e(route('mall.create')); ?>"
               class="flex items-center gap-2 px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-full font-semibold shadow transition">
                ➕ أضف متجر
            </a>
        <?php endif; ?>
    <?php endif; ?>

    <button id="toggleMallCategories"
        class="flex items-center gap-2 px-5 py-2 bg-yellow-400 hover:bg-yellow-500 text-black rounded-full font-semibold shadow transition">
        <i class="fas fa-th-large"></i> <?php echo e(__('messages.mall_categories')); ?>

    </button>

</div>


<?php
    $currentCategory = request('category');
    $categories = config('mall.categories');
?>

<div id="mallCategories" class="hidden flex flex-wrap items-center justify-center gap-3 mb-6">
<?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <a href="<?php echo e(route('mall.index', ['category' => $key])); ?>"
       class="px-5 py-2 rounded-full text-sm font-semibold transition
       <?php echo e($currentCategory == $key
            ? 'bg-yellow-400 text-black shadow'
            : 'bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 hover:bg-gray-300 dark:hover:bg-gray-600'); ?>">
        <?php echo e($label); ?>

    </a>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>

<script>
  document.getElementById("toggleMallCategories").addEventListener("click", function() {
    document.getElementById("mallCategories").classList.toggle("hidden");
  });
</script>


<h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mb-6">
    🏪 المتاجر <?php echo e($category ? 'في قسم: ' . $categories[$category] : ''); ?>

</h2>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 pb-10">
    <?php $__empty_1 = true; $__currentLoopData = $stores; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $store): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <a href="<?php echo e(route('mall.show', $store->id)); ?>" 
           class="block group rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm hover:shadow-xl transition">

<img src="<?php echo e($store->logo ? asset('storage/'.$store->logo) : asset('images/no-image.png')); ?>"
     alt="<?php echo e($store->name); ?>"
     class="w-full h-40 object-cover rounded-xl shadow bg-gray-100">

            <div class="p-3">
                <h3 class="font-semibold text-gray-800 dark:text-white group-hover:text-yellow-500 transition">
                    <?php echo e($store->name); ?>

                </h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1"><?php echo e(Str::limit($store->description, 45)); ?></p>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500 text-center col-span-full">لا توجد متاجر في هذا القسم.</p>
    <?php endif; ?>
</div>

<?php echo e($stores->links()); ?>



<?php if(isset($products) && $products->count()): ?>
<h2 class="text-2xl font-bold text-gray-800 dark:text-white text-center mt-10 mb-6">
    🛍️ منتجات من نفس القسم
</h2>

<div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-6 pb-20">
    <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <a href="<?php echo e(route('mall.products.show', ['store' => $product->store_id, 'product' => $product->id])); ?>" 
           class="block group rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm hover:shadow-xl transition">

<?php
    // ✅ تحويل الصور من JSON إلى مصفوفة في حال كانت نص
    $images = $product->images;

    if (is_string($images) && str_starts_with($images, '[')) {
        $images = json_decode($images, true);
    }

    if (!is_array($images)) {
        $images = [];
    }

    // ✅ اختيار أول صورة متاحة
    $firstImage = !empty($images) && isset($images[0])
        ? asset('storage/' . ltrim($images[0], '/'))
        : asset('images/no-image.png');
?>

<img src="<?php echo e($firstImage); ?>"
     alt="<?php echo e($product->name); ?>"
     class="w-full h-48 object-cover rounded-t-xl group-hover:scale-105 transition duration-300">

            <div class="p-3">
                <h3 class="font-semibold text-gray-800 dark:text-white group-hover:text-yellow-500 transition truncate">
                    <?php echo e($product->name); ?>

                </h3>
                <p class="text-sm font-bold text-yellow-600 dark:text-yellow-400 mt-1">
                    <?php echo e(number_format($product->price)); ?> ل.س
                </p>
            </div>
        </a>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php endif; ?>

    
    <div class="max-w-7xl mx-auto px-4">
        <?php echo e($stores->links()); ?>

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