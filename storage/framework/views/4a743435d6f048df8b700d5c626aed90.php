
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
<div class="w-full px-4 lg:px-24 xl:px-36 py-8">

    
    <div class="flex flex-wrap items-center justify-center gap-3 mb-6">
        <a href="<?php echo e(route('ads.index', ['category' => 'realestate'])); ?>" class="tab-link <?php echo e(request('category')=='realestate' ? 'active' : ''); ?>">
            <i class="fas fa-building"></i> <?php echo e(__('messages.real_estate')); ?>

        </a>
        <a href="<?php echo e(route('ads.index', ['category' => 'cars'])); ?>" class="tab-link <?php echo e(request('category')=='cars' ? 'active' : ''); ?>">
            <i class="fas fa-car"></i> <?php echo e(__('messages.cars')); ?>

        </a>
        <a href="<?php echo e(route('ads.index', ['category' => 'services'])); ?>" class="tab-link <?php echo e(request('category')=='services' ? 'active' : ''); ?>">
            <i class="fas fa-tools"></i> <?php echo e(__('messages.services')); ?>

        </a>
        <a href="<?php echo e(route('delni.taxi')); ?>" class="tab-link <?php echo e(request()->routeIs('delni.taxi') ? 'active' : ''); ?>">
            <i class="fas fa-taxi"></i> <?php echo e(__('messages.delni_taxi')); ?>

        </a>
<a href="<?php echo e(route('emergency_services.index')); ?>" class="tab-link <?php echo e(request()->routeIs('emergency_services.*') ? 'active' : ''); ?>">
    <i class="fas fa-ambulance"></i> <?php echo e(__('messages.delni_emergency')); ?>

</a>
    </div>

    
    <div class="flex justify-center gap-4 mb-6">
        <button id="toggleFilter" class="btn-yellow">
            <i class="fas fa-sliders-h"></i> <?php echo e(__('messages.filters')); ?>

        </button>
        <button id="toggleMap" class="btn-yellow">
            <i class="fas fa-map-marked-alt"></i> <?php echo e(__('messages.show_map')); ?>

        </button>
    </div>

    
    <form id="filterBox" method="GET" action="<?php echo e(route('ads.index')); ?>" 
          class="hidden bg-white dark:bg-gray-800 shadow-md rounded-2xl p-6 mb-12 w-full max-w-6xl mx-auto"
          x-data="{ category: '<?php echo e(request('category') ?? ''); ?>' }">

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="city" class="input">
                <option value=""><?php echo e(__('messages.select_city')); ?></option>
                <?php $__currentLoopData = ['دمشق','ريف دمشق','حلب','حمص','حماة','اللاذقية','طرطوس','درعا','السويداء','القنيطرة','إدلب','الرقة','دير الزور','الحسكة','تركيا']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $city): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($city); ?>" <?php echo e(request('city')==$city?'selected':''); ?>><?php echo e($city); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>

            <select name="category" x-model="category" class="input">
                <option value=""><?php echo e(__('messages.select_category')); ?></option>
                <option value="realestate" <?php echo e(request('category')=='realestate'?'selected':''); ?>>🏢 <?php echo e(__('messages.real_estate')); ?></option>
                <option value="cars" <?php echo e(request('category')=='cars'?'selected':''); ?>>🚗 <?php echo e(__('messages.cars')); ?></option>
                <option value="services" <?php echo e(request('category')=='services'?'selected':''); ?>>🛠️ <?php echo e(__('messages.services')); ?></option>
            </select>

            <input type="number" name="price_min" placeholder="<?php echo e(__('messages.price_from')); ?>" class="input" value="<?php echo e(request('price_min')); ?>">
            <input type="number" name="price_max" placeholder="<?php echo e(__('messages.price_to')); ?>" class="input" value="<?php echo e(request('price_max')); ?>">
        </div>

        
        <div x-show="category === 'realestate'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <select name="subcategory" class="input">
                <option value=""><?php echo e(__('messages.select_subcategory')); ?></option>
                <option value="residential" <?php echo e(request('subcategory')=='residential'?'selected':''); ?>>سكني</option>
                <option value="shop" <?php echo e(request('subcategory')=='shop'?'selected':''); ?>>محل تجاري</option>
                <option value="land" <?php echo e(request('subcategory')=='land'?'selected':''); ?>>أرض</option>
                <option value="villa" <?php echo e(request('subcategory')=='villa'?'selected':''); ?>>فيلا</option>
                <option value="office" <?php echo e(request('subcategory')=='office'?'selected':''); ?>>مكتب</option>
                <option value="building" <?php echo e(request('subcategory')=='building'?'selected':''); ?>>بناء</option>
            </select>
            <select name="deal_type" class="input">
                <option value=""><?php echo e(__('messages.deal_type')); ?></option>
                <option value="sale" <?php echo e(request('deal_type')=='sale'?'selected':''); ?>>بيع</option>
                <option value="rent" <?php echo e(request('deal_type')=='rent'?'selected':''); ?>>إيجار</option>
            </select>
            <input type="number" name="area_min" placeholder="<?php echo e(__('messages.area_from')); ?>" class="input" value="<?php echo e(request('area_min')); ?>">
            <input type="number" name="area_max" placeholder="<?php echo e(__('messages.area_to')); ?>" class="input" value="<?php echo e(request('area_max')); ?>">
        </div>

        <div x-show="category === 'cars'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <select name="car_brand" class="input">
                <option value=""><?php echo e(__('messages.select_car_brand')); ?></option>
                <?php $__currentLoopData = ['Audi','BMW','Mercedes-Benz','Toyota','Hyundai','Kia','Renault','Nissan','Volkswagen','Volvo','Chevrolet','Ford','Honda','Mazda']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $brand): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($brand); ?>" <?php echo e(request('car_brand')==$brand?'selected':''); ?>><?php echo e($brand); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
            <select name="car_year" class="input">
                <option value=""><?php echo e(__('messages.select_car_year')); ?></option>
                <?php for($y = date('Y'); $y >= 1980; $y--): ?>
                    <option value="<?php echo e($y); ?>" <?php echo e(request('car_year')==$y?'selected':''); ?>><?php echo e($y); ?></option>
                <?php endfor; ?>
            </select>
            <select name="fuel" class="input">
                <option value=""><?php echo e(__('messages.fuel')); ?></option>
                <option value="بنزين" <?php echo e(request('fuel')=='بنزين'?'selected':''); ?>>بنزين</option>
                <option value="ديزل" <?php echo e(request('fuel')=='ديزل'?'selected':''); ?>>ديزل</option>
                <option value="كهرباء" <?php echo e(request('fuel')=='كهرباء'?'selected':''); ?>>كهرباء</option>
                <option value="هجين" <?php echo e(request('fuel')=='هجين'?'selected':''); ?>>هجين</option>
            </select>
        </div>

        <div x-show="category === 'services'" class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <input type="text" name="service_type" placeholder="<?php echo e(__('messages.service_type')); ?>" class="input" value="<?php echo e(request('service_type')); ?>">
            <input type="text" name="provider_name" placeholder="<?php echo e(__('messages.provider_name')); ?>" class="input" value="<?php echo e(request('provider_name')); ?>">
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
            <select name="featured" class="input">
                <option value=""><?php echo e(__('messages.featured_status')); ?></option>
                <option value="1" <?php echo e(request('featured')=='1'?'selected':''); ?>>⭐ <?php echo e(__('messages.featured')); ?></option>
                <option value="0" <?php echo e(request('featured')=='0'?'selected':''); ?>>⚪ <?php echo e(__('messages.normal')); ?></option>
            </select>
            <select name="sort" class="input">
                <option value="latest" <?php echo e(request('sort')=='latest'?'selected':''); ?>>🆕 <?php echo e(__('messages.latest')); ?></option>
                <option value="price_desc" <?php echo e(request('sort')=='price_desc'?'selected':''); ?>>⬆️ <?php echo e(__('messages.price_high')); ?></option>
                <option value="price_asc" <?php echo e(request('sort')=='price_asc'?'selected':''); ?>>⬇️ <?php echo e(__('messages.price_low')); ?></option>
            </select>
        </div>

        <div class="flex justify-end mt-4 gap-3">
            <a href="<?php echo e(route('ads.index')); ?>" class="btn-gray">
                <i class="fas fa-undo"></i> <?php echo e(__('messages.reset_filters')); ?>

            </a>
            <button type="submit" class="btn-yellow">
                <i class="fas fa-search"></i> <?php echo e(__('messages.search')); ?>

            </button>
        </div>
    </form>

    
    <div id="mapBox" class="hidden mt-6 mb-12">
        <h2 class="section-title text-center">
            <i class="fas fa-map"></i> <?php echo e(__('messages.ads_on_map')); ?>

        </h2>
        <div id="adsMap" class="w-full h-[400px] rounded-lg shadow"></div>
    </div>


<div id="adsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php echo $__env->make('ads.partials.list', ['ads' => $ads], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>



<div class="mt-10 text-center">
    <?php if($ads->hasMorePages()): ?>
        <button id="loadMore" 
                data-next-page="<?php echo e($ads->currentPage() + 1); ?>" 
                class="btn-yellow px-6 py-3">
            <i class="fas fa-sync-alt"></i> <?php echo e(__('messages.load_more')); ?>

        </button>
    <?php endif; ?>
</div>


<div id="adsContainer" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mt-8"></div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const loadMoreBtn = document.getElementById("loadMore");
    const adsContainer = document.getElementById("adsContainer");

    if (loadMoreBtn) {
        loadMoreBtn.addEventListener("click", function () {
            let nextPage = this.getAttribute("data-next-page");
            let url = "<?php echo e(route('ads.index')); ?>" + "?page=" + nextPage + "&<?php echo http_build_query(request()->except('page')); ?>";

            fetch(url, { headers: { "X-Requested-With": "XMLHttpRequest" } })
                .then(res => res.text())
                .then(data => {
                    adsContainer.insertAdjacentHTML("beforeend", data);

                    // تحديث رقم الصفحة
                    this.setAttribute("data-next-page", parseInt(nextPage) + 1);

                    // إذا خلصت الصفحات -> أخفي الزر
                    if (data.trim() === "") {
                        this.remove();
                    }
                })
                .catch(err => console.error("⚠️ خطأ في تحميل المزيد:", err));
        });
    }
});
</script>


<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
    document.getElementById('toggleFilter').addEventListener('click', () => {
        document.getElementById('filterBox').classList.toggle('hidden');
    });

    document.getElementById('toggleMap').addEventListener('click', () => {
        document.getElementById('mapBox').classList.toggle('hidden');
    });

    document.addEventListener("DOMContentLoaded", function () {
        const map = L.map('adsMap').setView([34.8021, 38.9968], 7);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '&copy; Delni.co' }).addTo(map);

        fetch("<?php echo e(route('ads.mapData')); ?>")
            .then(res => res.json())
            .then(data => {
                data.forEach(ad => {
                    if (ad.lat && ad.lng) {
                        const marker = L.marker([ad.lat, ad.lng]).addTo(map);
                        const popupContent = `
                            <img src="${ad.first_image ?? '<?php echo e(asset('storage/placeholder.png')); ?>'}" style="width:100px;height:70px;object-fit:cover;border-radius:8px;margin-bottom:5px;">
                            <strong>${ad.title}</strong><br>
                            <i class='fas fa-map-marker-alt text-red-500'></i> ${ad.city}<br>
                            <i class='fas fa-dollar-sign text-green-600'></i> ${ad.price} <?php echo e(__('messages.currency')); ?><br>
                            <a href="/ads/${ad.slug}" class="text-blue-600 underline">
                                <i class='fas fa-eye'></i> <?php echo e(__('messages.view_ad')); ?>

                            </a>
                        `;
                        marker.bindPopup(popupContent);
                    }
                });
            })
            .catch(err => console.error("⚠️ خطأ بجلب بيانات الخريطة:", err));
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
<?php /**PATH /home/delni_user/delni/resources/views/ads/index.blade.php ENDPATH**/ ?>