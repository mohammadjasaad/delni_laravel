
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($product->name)]); ?>

<div class="max-w-6xl mx-auto px-4 py-10">

    
    <div class="text-sm text-gray-500 mb-4">
        <a href="<?php echo e(route('mall.index')); ?>" class="hover:text-yellow-500">🛍️ دلني مول</a> /
        <a href="<?php echo e(route('mall.show', $store->id)); ?>" class="hover:text-yellow-500"><?php echo e($store->name); ?></a> /
        <span class="text-gray-800 dark:text-gray-200"><?php echo e($product->name); ?></span>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-10">


<div>
    <div class="swiper productSwiper relative rounded-xl overflow-hidden shadow-lg">

        <div class="swiper-wrapper">
            <?php if(is_array($product->images) && count($product->images) > 0): ?>
                <?php $__currentLoopData = $product->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <img src="<?php echo e(asset('storage/'.$img)); ?>" class="w-full h-96 object-cover">
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="swiper-slide">
                    <img src="<?php echo e(asset('images/no-image.png')); ?>" class="w-full h-96 object-cover">
                </div>
            <?php endif; ?>
        </div>

        
        <div class="swiper-pagination"></div>

        
        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>

    </div>
</div>

        
        <div class="space-y-6">
            <h1 class="text-3xl font-bold text-gray-800 dark:text-white">
                <?php echo e($product->name); ?>

            </h1>

            <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                <?php echo e($product->description); ?>

            </p>

            <div class="text-3xl font-bold text-yellow-500">
                💰 <?php echo e(number_format($product->price)); ?> ل.س
            </div>

            
            <a href="https://wa.me/?text=<?php echo e(urlencode('مرحبا، أريد الاستفسار عن المنتج: '.$product->name.' من متجر '.$store->name.' رابط المنتج: '.url()->current())); ?>"
               class="w-full flex items-center justify-center gap-2 bg-green-500 hover:bg-green-600 text-white py-3 rounded-xl shadow text-lg font-semibold transition">
                📩 تواصل عبر واتساب
            </a>

<form action="<?php echo e(route('cart.add', [$store->id, $product->id])); ?>" method="POST">
    <?php echo csrf_field(); ?>
    <button type="submit"
        class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white py-3 rounded-xl shadow text-lg font-semibold transition">
        🛒 أضف للسلة
    </button>
</form>
            
            <a href="<?php echo e(route('mall.show', $store->id)); ?>"
               class="w-full flex items-center justify-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black py-3 rounded-xl shadow text-lg font-semibold transition">
                🏪 زيارة متجر <?php echo e($store->name); ?>

            </a>

        </div>
    </div>

</div>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css"/>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script>
    new Swiper(".productSwiper", {
        loop: true,
        slidesPerView: 1,
        spaceBetween: 10,
        autoplay: { delay: 3000 },
        pagination: { el: ".swiper-pagination", clickable: true },
        navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
    });
</script>


<?php if($relatedProducts->count() > 0): ?>
<div class="mt-16">
    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
        🔥 منتجات مشابهة من نفس المتجر
    </h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
        <?php $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                // نحاول جلب الصور من JSON أو من النص العادي
                $images = $item->images;

                // في حال كانت JSON نحولها
                if (is_string($images) && str_starts_with($images, '[')) {
                    $images = json_decode($images, true);
                }

                // إذا ليست مصفوفة نحولها إلى مصفوفة فارغة
                if (!is_array($images)) {
                    $images = [];
                }

                // نأخذ أول صورة صحيحة فقط
                $firstImage = !empty($images) && isset($images[0])
                    ? asset('storage/' . ltrim($images[0], '/'))
                    : asset('images/no-image.png');
            ?>

            <a href="<?php echo e(route('mall.products.show', [$store->id, $item->id])); ?>" class="block group">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    <img src="<?php echo e($firstImage); ?>"
                         alt="<?php echo e($item->name); ?>"
                         class="w-full h-48 object-cover rounded-t-xl group-hover:opacity-90 transition duration-300">

                    <div class="p-3 space-y-1">
                        <h3 class="font-semibold text-gray-800 dark:text-white truncate">
                            <?php echo e($item->name); ?>

                        </h3>
                        <div class="text-yellow-600 font-bold">
                            💰 <?php echo e(number_format($item->price)); ?> ل.س
                        </div>
                    </div>
                </div>
            </a>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php endif; ?>

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
<?php /**PATH /home/delni_user/delni/resources/views/products/show.blade.php ENDPATH**/ ?>