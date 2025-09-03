
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
<div class="max-w-6xl mx-auto px-4 py-8">

    
    <?php
        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        $mainImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
    ?>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div>
            <img src="<?php echo e($mainImage); ?>" class="w-full h-96 object-cover rounded-xl shadow" alt="ad">
            <?php if($images && count($images) > 1): ?>
                <div class="flex gap-2 mt-3 overflow-x-auto">
                    <?php $__currentLoopData = array_slice($images,1); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <img src="<?php echo e(asset('storage/'.$img)); ?>" 
                             class="w-28 h-20 object-cover rounded border hover:scale-105 transition" alt="thumb">
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>

        
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-3"><i class="fas fa-bullhorn"></i> <?php echo e($ad->title); ?></h1>
            <p class="text-gray-500 mb-2"><i class="fas fa-map-marker-alt text-red-500"></i> <?php echo e($ad->city); ?></p>
            <p class="text-red-600 text-xl font-bold mb-4"><i class="fas fa-dollar-sign"></i> <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?></p>

            
            <?php if($ad->is_featured): ?>
                <span class="inline-block bg-yellow-400 text-black text-xs font-bold px-3 py-1 rounded-full mb-4">
                    <i class="fas fa-star"></i> <?php echo e(__('messages.featured')); ?>

                </span>
            <?php endif; ?>

            
            <div x-data="{ tab: 'details' }" class="mt-4">
                <div class="flex gap-6 border-b mb-4">
                    <button @click="tab='details'" :class="tab==='details' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
                        <i class="fas fa-info-circle"></i> <?php echo e(__('messages.details')); ?>

                    </button>
                    <button @click="tab='description'" :class="tab==='description' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
                        <i class="fas fa-align-left"></i> <?php echo e(__('messages.description')); ?>

                    </button>
                    <button @click="tab='map'" :class="tab==='map' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" class="pb-2 flex items-center gap-1">
                        <i class="fas fa-map"></i> <?php echo e(__('messages.location')); ?>

                    </button>
                </div>

                
                <div x-show="tab==='details'" class="space-y-4">
                    <?php if($ad->category === 'عقارات' || $ad->category === 'realestate'): ?>
                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-bold mb-4"><i class="fas fa-home"></i> <?php echo e(__('messages.real_estate_details')); ?></h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <p><i class="fas fa-tag text-gray-500"></i> <?php echo e(__('messages.subcategory')); ?>: <?php echo e($ad->subcategory ?? '-'); ?></p>
                                <p><i class="fas fa-bed text-gray-500"></i> <?php echo e(__('messages.rooms')); ?>: <?php echo e($ad->rooms ?? '-'); ?></p>
                                <p><i class="fas fa-bath text-gray-500"></i> <?php echo e(__('messages.bathrooms')); ?>: <?php echo e($ad->bathrooms ?? '-'); ?></p>
                                <p><i class="fas fa-ruler-combined text-gray-500"></i> <?php echo e(__('messages.area')); ?>: <?php echo e($ad->area ?? '-'); ?> م²</p>
                                <p><i class="fas fa-building text-gray-500"></i> <?php echo e(__('messages.floor')); ?>: <?php echo e($ad->floor ?? '-'); ?></p>
                                <p><i class="fas fa-industry text-gray-500"></i> <?php echo e(__('messages.building_age')); ?>: <?php echo e($ad->building_age ?? '-'); ?></p>
                                <p><i class="fas fa-elevator text-gray-500"></i> <?php echo e(__('messages.elevator')); ?>: <?php echo e($ad->has_elevator ? __('messages.yes') : __('messages.no')); ?></p>
                                <p><i class="fas fa-parking text-gray-500"></i> <?php echo e(__('messages.parking')); ?>: <?php echo e($ad->has_parking ? __('messages.yes') : __('messages.no')); ?></p>
                                <p><i class="fas fa-fire text-gray-500"></i> <?php echo e(__('messages.heating')); ?>: <?php echo e($ad->heating_type ?? '-'); ?></p>
                            </div>
                        </div>

                    <?php elseif($ad->category === 'سيارات' || $ad->category === 'cars'): ?>
                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-bold mb-4"><i class="fas fa-car"></i> <?php echo e(__('messages.car_details')); ?></h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <p><i class="fas fa-car-side text-gray-500"></i> <?php echo e(__('messages.car_model')); ?>: <?php echo e($ad->car_model ?? '-'); ?></p>
                                <p><i class="fas fa-calendar-alt text-gray-500"></i> <?php echo e(__('messages.car_year')); ?>: <?php echo e($ad->car_year ?? '-'); ?></p>
                                <p><i class="fas fa-tachometer-alt text-gray-500"></i> <?php echo e(__('messages.car_km')); ?>: <?php echo e($ad->car_km ?? '-'); ?> كم</p>
                                <p><i class="fas fa-gas-pump text-gray-500"></i> <?php echo e(__('messages.fuel')); ?>: <?php echo e($ad->fuel ?? '-'); ?></p>
                                <p><i class="fas fa-cogs text-gray-500"></i> <?php echo e(__('messages.gearbox')); ?>: <?php echo e($ad->gearbox ?? '-'); ?></p>
                                <p><i class="fas fa-palette text-gray-500"></i> <?php echo e(__('messages.color')); ?>: <?php echo e($ad->car_color ?? '-'); ?></p>
                                <p><i class="fas fa-check-circle text-gray-500"></i> <?php echo e(__('messages.condition')); ?>: <?php echo e($ad->is_new ? __('messages.new') : __('messages.used')); ?></p>
                            </div>
                        </div>

                    <?php elseif($ad->category === 'خدمات' || $ad->category === 'services'): ?>
                        <div class="bg-white rounded-xl shadow p-6">
                            <h2 class="text-lg font-bold mb-4"><i class="fas fa-tools"></i> <?php echo e(__('messages.service_details')); ?></h2>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                <p><i class="fas fa-wrench text-gray-500"></i> <?php echo e(__('messages.service_type')); ?>: <?php echo e($ad->service_type ?? '-'); ?></p>
                                <p><i class="fas fa-user-tie text-gray-500"></i> <?php echo e(__('messages.provider_name')); ?>: <?php echo e($ad->provider_name ?? '-'); ?></p>
                            </div>
                        </div>

                    <?php else: ?>
                        <p><i class="fas fa-folder-open text-gray-500"></i> <?php echo e($ad->category); ?></p>
                    <?php endif; ?>
                </div>

                
                <div x-show="tab==='description'" class="text-gray-700 leading-relaxed">
                    <?php echo e($ad->description ?: __('messages.no_description')); ?>

                </div>

                
                <div x-show="tab==='map'" class="mt-4">
                  <div id="map" class="w-full h-[400px] md:h-[500px] rounded-lg shadow"></div>
                </div>
            </div>

            
            <div class="flex gap-3 mt-6">
                <a href="tel:+963988779548" class="btn-yellow bg-green-500 hover:bg-green-600">
                    <i class="fas fa-phone"></i> <?php echo e(__('messages.call')); ?>

                </a>
                <form method="POST" action="<?php echo e(route('ads.favorite', $ad->id)); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn-yellow bg-yellow-500 hover:bg-yellow-600">
                        <i class="fas fa-heart"></i> <?php echo e(__('messages.add_to_favorite')); ?>

                    </button>
                </form>
            </div>
        </div>
    </div>

    
    <div class="mt-12">
        <h2 class="text-xl font-bold mb-4"><i class="fas fa-search"></i> <?php echo e(__('messages.related_ads')); ?></h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $relatedAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $imgs = is_array($item->images) ? $item->images : json_decode($item->images, true);
                    $img  = !empty($imgs[0]) ? asset('storage/'.$imgs[0]) : asset('storage/placeholder.png');
                ?>
                <a href="<?php echo e(route('ads.show', $item->id)); ?>" class="block bg-white rounded-xl shadow hover:shadow-lg overflow-hidden">
                    <img src="<?php echo e($img); ?>" class="w-full h-40 object-cover" alt="related">
                    <div class="p-3">
                        <h3 class="font-bold truncate"><?php echo e($item->title); ?></h3>
                        <p class="text-sm text-gray-500"><i class="fas fa-map-marker-alt"></i> <?php echo e($item->city); ?></p>
                        <p class="text-red-600 font-bold text-sm"><i class="fas fa-dollar-sign"></i> <?php echo e(number_format($item->price)); ?> <?php echo e(__('messages.currency')); ?></p>
                    </div>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const lat = <?php echo e($ad->lat ?? 33.5138); ?>;
        const lng = <?php echo e($ad->lng ?? 36.2765); ?>;
        const map = L.map('map').setView([lat, lng], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; Delni.co'
        }).addTo(map);
        L.marker([lat, lng]).addTo(map).bindPopup("<?php echo e($ad->title); ?>");
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
<?php /**PATH /home/delni_user/delni/resources/views/ads/show.blade.php ENDPATH**/ ?>