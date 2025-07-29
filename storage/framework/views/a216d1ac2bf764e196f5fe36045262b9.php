
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
    <div class="max-w-4xl mx-auto py-10 px-4 text-gray-800">

        <h1 class="text-3xl font-bold mb-6 text-center text-yellow-500">
            <?php echo e(__('messages.about_us')); ?>

        </h1>

        <div class="bg-white rounded-lg shadow p-6 space-y-4 leading-relaxed">
            <p>
                منصة <strong>دلني Delni.co</strong> هي وجهتك الأولى للإعلانات المبوبة في سوريا، نقدم لك طريقة سهلة وموثوقة لنشر وبيع العقارات والسيارات بكل احترافية.
            </p>

            <p>
                مهمتنا هي ربط البائعين بالمشترين من خلال واجهة بسيطة وسريعة، دون وسطاء، وبأقصى درجات الأمان والراحة.
            </p>

            <p>
                يمكنك تصفح آلاف الإعلانات، أو نشر إعلانك الخاص خلال دقائق فقط.
            </p>

            <p>
                دلني هو مشروع مستقل تم تطويره بخبرة وشغف لتقديم تجربة رقمية فريدة لكل السوريين في الداخل والخارج.
            </p>
        </div>

        <div class="mt-8 text-center">
            <a href="<?php echo e(route('ads.index')); ?>" class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold px-6 py-2 rounded">
                <?php echo e(__('messages.browse_ads')); ?>

            </a>
        </div>

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
<?php /**PATH /home/delni_user/delni/resources/views/about.blade.php ENDPATH**/ ?>