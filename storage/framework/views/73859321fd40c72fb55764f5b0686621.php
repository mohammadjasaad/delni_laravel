<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\GuestLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="w-full px-4 lg:px-24 xl:px-36 py-8">

        
        <div class="flex flex-wrap items-center justify-between gap-4 mb-8">
            <div class="flex flex-wrap gap-2">
                <a href="<?php echo e(route('home', ['filter' => 'realestate'])); ?>"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   <?php echo e(request('filter') == 'realestate' ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700'); ?>">
                    🏠 <?php echo e(__('messages.real_estate')); ?>

                </a>
                <a href="<?php echo e(route('home', ['filter' => 'cars'])); ?>"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   <?php echo e(request('filter') == 'cars' ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700'); ?>">
                    🚗 <?php echo e(__('messages.cars')); ?>

                </a>
                <a href="<?php echo e(route('home', ['filter' => 'services'])); ?>"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   <?php echo e(request('filter') == 'services' ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700'); ?>">
                    🛠️ <?php echo e(__('messages.services')); ?>

                </a>
                <a href="<?php echo e(route('taxi.request')); ?>"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   <?php echo e(request()->routeIs('taxi.request') ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700'); ?>">
                    🚖 Delni Taxi
                </a>
                <a href="<?php echo e(route('emergency.index')); ?>"
                   class="px-4 py-2 rounded-full whitespace-nowrap transition 
                   <?php echo e(request()->routeIs('emergency.index') ? 'bg-yellow-400 text-black font-bold' : 'bg-gray-200 text-gray-700'); ?>">
                   🚨 دلني عاجل
                </a>
            </div>

            
            <div class="text-sm whitespace-nowrap">
                <a href="<?php echo e(route('lang.switch', 'ar')); ?>" class="mx-1 <?php echo e(app()->getLocale() == 'ar' ? 'font-bold underline' : ''); ?>">العربية</a> |
                <a href="<?php echo e(route('lang.switch', 'en')); ?>" class="mx-1 <?php echo e(app()->getLocale() == 'en' ? 'font-bold underline' : ''); ?>">English</a>
            </div>
        </div>

        
        <form method="GET" action="<?php echo e(route('home')); ?>" class="bg-white shadow-md rounded-2xl p-6 mb-8 w-full max-w-6xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-center">
                <input type="text" name="city" placeholder="<?php echo e(__('messages.search_city')); ?>"
                       class="w-full p-3 border rounded-xl text-sm" value="<?php echo e(request('city')); ?>">

                <input type="number" name="price_min" placeholder="<?php echo e(__('messages.price_from')); ?>"
                       class="w-full p-3 border rounded-xl text-sm" value="<?php echo e(request('price_min')); ?>">

                <input type="number" name="price_max" placeholder="<?php echo e(__('messages.price_to')); ?>"
                       class="w-full p-3 border rounded-xl text-sm" value="<?php echo e(request('price_max')); ?>">

                <select name="category" class="w-full p-3 border rounded-xl text-sm">
                    <option value=""><?php echo e(__('messages.select_category')); ?></option>
                    <option value="realestate" <?php echo e(request('category') == 'realestate' ? 'selected' : ''); ?>><?php echo e(__('messages.real_estate')); ?></option>
                    <option value="cars" <?php echo e(request('category') == 'cars' ? 'selected' : ''); ?>><?php echo e(__('messages.cars')); ?></option>
                    <option value="services" <?php echo e(request('category') == 'services' ? 'selected' : ''); ?>><?php echo e(__('messages.services')); ?></option>
                </select>

                <button type="submit" class="bg-red-500 text-white px-4 py-3 rounded-xl hover:bg-red-600 text-sm flex justify-center items-center gap-1">
                    🔍 <?php echo e(__('messages.search')); ?>

                </button>
            </div>
        </form>

        
        <div class="mt-10 mb-16">
            <h2 class="text-2xl font-bold text-yellow-600 mb-4 text-center">🗺️ عرض الإعلانات على الخريطة</h2>
            <div id="adsMap" class="w-full h-[500px] rounded-lg shadow"></div>
        </div>

<?php if($featuredAds->count() > 0): ?>
    <div class="mt-12">
        <h2 class="text-2xl font-bold text-yellow-600 mb-6 text-center">⭐ <?php echo e(__('messages.featured_ads')); ?></h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            <?php $__currentLoopData = $featuredAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="relative bg-white border border-yellow-300 rounded-lg overflow-hidden shadow-md hover:shadow-lg transition">


<div class="absolute top-0 right-0 z-10">
    <div class="animate-pulse bg-yellow-400 text-white text-xs font-bold px-8 py-1 transform rotate-45 translate-x-8 -translate-y-4 shadow-md">
        ⭐ مميز
    </div>
</div>

                    <img src="<?php echo e(asset('storage/' . $ad->images[0])); ?>" alt="ad image" class="w-full h-40 object-cover">

                    <div class="p-4">
                        <h3 class="text-lg font-semibold text-gray-800 truncate"><?php echo e($ad->title); ?></h3>
                        <p class="text-sm text-gray-500"><?php echo e($ad->city); ?></p>
                        <p class="text-red-600 font-bold mt-2"><?php echo e($ad->price); ?> <?php echo e(__('messages.currency')); ?></p>
                        <a href="<?php echo e(route('ads.show', $ad->id)); ?>" class="block mt-4 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-1 rounded">
                            <?php echo e(__('messages.view_ad')); ?>

                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
<?php endif; ?>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="bg-white rounded-xl shadow hover:shadow-lg overflow-hidden transition duration-300">
<?php
    $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
?>

<img src="<?php echo e(isset($images[0]) ? asset('storage/' . $images[0]) : '/placeholder.png'); ?>"
     alt="image"
     class="w-full h-48 object-cover">

<?php if(isset($featuredAds) && $featuredAds->count() > 0): ?>
    
<?php endif; ?>

                    <div class="p-4">
                        <h2 class="font-semibold text-base truncate mb-1"><?php echo e($ad->title); ?></h2>
                        <p class="text-gray-600 text-sm"><?php echo e($ad->city); ?></p>
                        <p class="text-red-600 font-bold text-sm mt-2"><?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?></p>
                        <p class="text-gray-400 text-xs mt-1"><?php echo e(__('messages.category')); ?>: <?php echo e(ucfirst($ad->category)); ?></p>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-center col-span-4 text-gray-500 mt-8"><?php echo e(__('messages.no_ads_found')); ?></p>
            <?php endif; ?>
        </div>
    </div>

    
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const map = L.map('adsMap').setView([34.8021, 38.9968], 7); // مركز سوريا

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; Delni.co'
            }).addTo(map);

            const ads = <?php echo json_encode($ads, 15, 512) ?>;

            ads.forEach(ad => {
                if (ad.lat && ad.lng) {
                    const marker = L.marker([ad.lat, ad.lng]).addTo(map);
const img = ad.images && ad.images.length > 0
    ? `<img src="/storage/${ad.images[0]}" alt="" style='width:100px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:5px;'>`
    : `<img src="/placeholder.png" alt="" style='width:100px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:5px;'>`;

marker.bindPopup(`
    ${img}
    <strong>${ad.title}</strong><br>
    ${ad.city}<br>
    💰 ${ad.price} <?php echo e(__('messages.currency')); ?><br>
    <a href="/ads/${ad.id}" class="text-blue-600 underline">عرض الإعلان</a>
`);

                }
            });
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/home.blade.php ENDPATH**/ ?>