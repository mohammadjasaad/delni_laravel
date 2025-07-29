
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
    <div class="max-w-6xl mx-auto px-4 py-10">

        
        <div class="mb-6">
            <a href="<?php echo e(route('ads.index')); ?>" class="text-yellow-600 hover:underline text-sm">
                ← <?php echo e(__('messages.back_to_ads')); ?>

            </a>
        </div>

        
        <h1 class="text-3xl font-extrabold text-center text-gray-800 mb-4"><?php echo e($ad->title); ?></h1>

        
        <?php if($ad->is_featured): ?>
            <div class="text-center mb-6">
                <span class="inline-block bg-yellow-400 text-white font-bold px-4 py-2 rounded-full shadow">
                    ⭐ <?php echo e(__('messages.featured_ad')); ?>

                </span>
            </div>
        <?php endif; ?>

        
        <?php
            $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        ?>

        <?php if($images && count($images) > 0): ?>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
                <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <img src="<?php echo e(asset('storage/' . $image)); ?>" alt="Ad Image"
                         class="rounded-xl shadow-md h-64 w-full object-cover hover:scale-105 transition duration-300">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <img src="/placeholder.png" alt="No Image"
                 class="rounded-xl shadow-md h-64 w-full object-cover mb-6 opacity-60">
        <?php endif; ?>

        
        <div class="bg-white rounded-2xl shadow-md p-6 grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 text-gray-700 text-lg">
            <p><strong class="text-gray-900"><?php echo e(__('messages.price')); ?>:</strong>
                <span class="text-yellow-600 font-bold">💰 <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?></span>
            </p>
            <p><strong class="text-gray-900"><?php echo e(__('messages.city')); ?>:</strong> 📍 <?php echo e($ad->city); ?></p>
            <p><strong class="text-gray-900"><?php echo e(__('messages.category')); ?>:</strong> 🗂️ <?php echo e($ad->category); ?></p>
            <p><strong class="text-gray-900"><?php echo e(__('messages.created_at')); ?>:</strong> ⏰ <?php echo e($ad->created_at->format('Y-m-d H:i')); ?></p>
        </div>

        
        <?php if(auth()->guard()->check()): ?>
            <form method="POST" action="<?php echo e(route('favorites.store', $ad->id)); ?>" class="text-center mb-8">
                <?php echo csrf_field(); ?>
                <button type="submit"
                        class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-8 rounded-full shadow-md">
                    ❤️ <?php echo e(__('messages.add_to_favorite')); ?>

                </button>
            </form>
        <?php endif; ?>

        
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <h2 class="text-2xl font-extrabold text-gray-800 mb-4">📝 <?php echo e(__('messages.description')); ?></h2>
            <p class="text-base text-gray-700 leading-relaxed whitespace-pre-line"><?php echo e($ad->description); ?></p>
        </div>

        
        <div class="bg-white rounded-2xl shadow-md p-6 mb-8">
            <h2 class="text-xl font-bold text-red-600 mb-4">🚨 <?php echo e(__('messages.report_ad')); ?></h2>
            <?php if(auth()->guard()->check()): ?>
                <form method="POST" action="<?php echo e(route('ads.report', $ad->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <textarea name="message" rows="3" class="w-full p-3 border rounded-xl text-sm mb-3"
                              placeholder="<?php echo e(__('messages.report_message_placeholder')); ?>"></textarea>
                    <button type="submit"
                            class="bg-red-500 hover:bg-red-600 text-white font-semibold px-5 py-2 rounded-lg text-sm shadow">
                        <?php echo e(__('messages.submit_report')); ?>

                    </button>
                </form>
            <?php else: ?>
                <p class="text-sm text-gray-600"><?php echo e(__('messages.login_to_report')); ?></p>
            <?php endif; ?>
        </div>

        
        <div class="text-center mt-8">
            <a href="https://wa.me/?text=<?php echo e(urlencode('مرحبا، أنا مهتم بالإعلان: ' . $ad->title . ' على موقع Delni.co. الرابط: ' . url()->current())); ?>"
               target="_blank"
               class="inline-block bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-8 rounded-full shadow transition">
                📲 <?php echo e(__('messages.contact_on_whatsapp')); ?>

            </a>
        </div>

        
        <?php if($ad->lat && $ad->lng): ?>
            <div class="mt-16">
                <h2 class="text-2xl font-bold text-yellow-600 mb-4 text-center">📍 <?php echo e(__('messages.ad_location')); ?></h2>
                <div id="adMap" class="w-full h-[400px] rounded-lg shadow"></div>
            </div>

            
            <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
            <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

            <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const map = L.map('adMap').setView([<?php echo e($ad->lat); ?>, <?php echo e($ad->lng); ?>], 15);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        attribution: '&copy; Delni.co'
                    }).addTo(map);
                    const marker = L.marker([<?php echo e($ad->lat); ?>, <?php echo e($ad->lng); ?>]).addTo(map);
                    marker.bindPopup(`
                        <strong><?php echo e($ad->title); ?></strong><br>
                        📍 <?php echo e($ad->city); ?><br>
                        💰 <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?>

                    `);
                });
            </script>
        <?php endif; ?>

        
        <?php if($relatedAds->count()): ?>
            <div class="mt-20">
                <h2 class="text-2xl font-bold text-yellow-600 mb-6 text-center">🧭 <?php echo e(__('messages.related_ads')); ?></h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <?php $__currentLoopData = $relatedAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $related): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $images = is_array($related->images) ? $related->images : json_decode($related->images, true);
                        ?>
                        <a href="<?php echo e(route('ads.show', $related->id)); ?>"
                           class="block bg-white rounded-xl shadow hover:shadow-xl overflow-hidden transition duration-300">
                            <img src="<?php echo e(asset('storage/' . ($images[0] ?? 'placeholder.png'))); ?>"
                                 alt="Ad Image" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-base truncate mb-1"><?php echo e($related->title); ?></h3>
                                <p class="text-gray-600 text-sm">📍 <?php echo e($related->city); ?></p>
                                <p class="text-yellow-600 font-bold text-sm mt-2">💰 <?php echo e(number_format($related->price)); ?> <?php echo e(__('messages.currency')); ?></p>
                            </div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
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
<?php /**PATH /home/delni_user/delni/resources/views/ads/show.blade.php ENDPATH**/ ?>