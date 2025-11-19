
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

<div x-data="{ mainImage: '<?php echo e($mainImage); ?>' }">
    
    
    <a :href="mainImage" data-lightbox="ad-gallery" data-title="<?php echo e($ad->title); ?>">
        <img :src="mainImage" id="mainImage"
             class="w-full h-96 object-cover rounded-xl shadow cursor-pointer" 
             alt="<?php echo e($ad->title); ?>">
    </a>
    
    <?php if($images && count($images) > 1): ?>
        <div class="flex gap-2 mt-3 overflow-x-auto">
            <?php $__currentLoopData = $images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <img src="<?php echo e(asset('storage/'.$img)); ?>"
                     class="w-28 h-20 object-cover rounded border hover:scale-105 transition cursor-pointer"
                     alt="<?php echo e($ad->title); ?>"
                     onclick="document.getElementById('mainImage').src=this.src;
                              document.querySelector('a[data-lightbox=\'ad-gallery\']').href=this.src;">
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mb-6 flex items-center justify-between">
    <div>
        <h3 class="text-lg font-bold text-gray-800 dark:text-gray-100">
            <?php echo e($ad->user->name ?? 'مستخدم'); ?>

        </h3>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            📞 <?php echo e($ad->user->phone ?? 'لا يوجد رقم'); ?>

        </p>
        <p class="text-xs text-gray-500 dark:text-gray-400">
            <?php echo e($ad->user->ads()->count()); ?> إعلان
        </p>
        
        <?php if(isset($providerRatingCount) && $providerRatingCount > 0): ?>
            <div class="flex items-center gap-2 mt-2 text-yellow-500 text-sm">
                ⭐ <?php echo e(number_format($providerRatingAvg, 1)); ?>

                <span class="text-gray-500 text-xs">(<?php echo e($providerRatingCount); ?> تقييم)</span>
            </div>
        <?php else: ?>
            <p class="text-gray-400 text-sm mt-1">لا توجد تقييمات بعد</p>
        <?php endif; ?>

    </div>
<a href="<?php echo e(route('user.ads', $ad->user->id)); ?>" 
   class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-1.5 rounded-md shadow text-sm font-medium">
    <i class="fas fa-list"></i> <?php echo e(__('messages.view_all_ads')); ?>

</a>
</div>
</div>
        
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-3">

<?php
    $dealType = $ad->deal_type;
    if (in_array($dealType, ['sale', 'بيع'])) $dealLabel = '🚩 بيع';
    elseif (in_array($dealType, ['rent', 'إيجار'])) $dealLabel = '🏠 إيجار';
    else $dealLabel = '-';
?>

<span class="inline-block bg-blue-100 text-blue-700 font-bold px-3 py-1 rounded-lg shadow-sm text-sm mb-3">
    <?php echo e($dealLabel); ?>

</span>

    <i class="fas fa-bullhorn"></i> <?php echo e($ad->title); ?>

</h1>
<p class="text-gray-500 dark:text-gray-300 mb-2">
    <i class="fas fa-map-marker-alt text-red-500"></i> <?php echo e($ad->city); ?>

</p>


<div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-300 mb-4">
    <div class="flex items-center gap-1">
        <i class="fas fa-hashtag text-yellow-500"></i>
        <span>رقم الإعلان:</span>
        <span class="font-semibold text-gray-800 dark:text-gray-100"><?php echo e($ad->reference ?? '—'); ?></span>
    </div>
    <div class="flex items-center gap-1">
        <i class="fas fa-calendar-alt text-yellow-500"></i>
        <span>تاريخ النشر:</span>
        <span class="font-semibold text-gray-800 dark:text-gray-100"><?php echo e($ad->created_at->format('Y-m-d')); ?></span>
    </div>
</div>


<div class="flex items-center gap-2 mb-4">
    <?php if($ad->currency === 'USD'): ?>
        <span class="bg-green-100 text-green-700 font-bold px-3 py-1 rounded-lg shadow-sm text-lg">
            <i class="fas fa-dollar-sign"></i> <?php echo e(number_format($ad->price, 0)); ?>

        </span>
        <span class="text-gray-500 text-sm">دولار أمريكي</span>
    <?php else: ?>
        <span class="bg-yellow-100 text-yellow-700 font-bold px-3 py-1 rounded-lg shadow-sm text-lg">
            <?php echo e(number_format($ad->price, 0)); ?> ل.س
        </span>
        <span class="text-gray-500 text-sm">الليرة السورية</span>
    <?php endif; ?>
</div>
            
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
<button @click="tab='map'; setTimeout(()=>map.invalidateSize(),300)" 
        :class="tab==='map' ? 'border-b-2 border-yellow-500 font-bold text-yellow-600' : ''" 
        class="pb-2 flex items-center gap-1">
    <i class="fas fa-map"></i> <?php echo e(__('messages.location')); ?>

</button>
                </div>

<div x-show="tab==='details'" class="space-y-4">
<?php
    $cat = strtolower(trim($ad->category ?? ''));
?>


<?php if(in_array($cat, ['عقارات','realestate','real estate'])): ?>
    <?php
        $dealTypeMap = ['sale'=>'بيع','rent'=>'إيجار','بيع'=>'بيع','إيجار'=>'إيجار',''=> '-', null => '-'];
        $subcategoryMap = ['residential'=>'سكني','commercial'=>'تجاري','land'=>'أرض','villa'=>'فيلا','office'=>'مكتب','building'=>'بناء كامل'];
        $floorMap = ['ground'=>'الأرضي','1'=>'الأول','2'=>'الثاني','3'=>'الثالث','4'=>'الرابع','5'=>'الخامس','6+'=>'أعلى من الخامس'];
        $ageMap   = ['new'=>'جديد','1-5'=>'1 - 5 سنوات','6-10'=>'6 - 10 سنوات','10+'=>'أكثر من 10 سنوات'];
        $heatingMap = ['مركزي'=>'مركزي','غاز'=>'غاز','كهرباء'=>'كهرباء','مازوت'=>'مازوت','بدون'=>'بدون تدفئة'];
    ?>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-gray-100 border-b pb-2">
            <i class="fas fa-home text-yellow-500"></i> تفاصيل العقار
        </h2>

        <?php
            $fields = [
                ['icon'=>'fa-tag','label'=>'نوع العرض','value'=>$dealLabel],
                ['icon'=>'fa-list','label'=>'نوع العقار','value'=>$subcategoryMap[$ad->subcategory] ?? '-'],
                ['icon'=>'fa-bed','label'=>'عدد الغرف','value'=>$ad->rooms ?? '-'],
                ['icon'=>'fa-bath','label'=>'عدد الحمامات','value'=>$ad->bathrooms ?? '-'],
                ['icon'=>'fa-ruler-combined','label'=>'المساحة الإجمالية','value'=>$ad->area_total ? $ad->area_total.' م²' : '-'],
                ['icon'=>'fa-ruler','label'=>'المساحة الصافية','value'=>$ad->area_net ? $ad->area_net.' م²' : '-'],
                ['icon'=>'fa-building','label'=>'الطابق','value'=>$floorMap[$ad->floor] ?? ($ad->floor ?? '-')],
                ['icon'=>'fa-hourglass-half','label'=>'عمر البناء','value'=>$ageMap[$ad->building_age] ?? ($ad->building_age ?? '-')],
                ['icon'=>'fa-fire','label'=>'نوع التدفئة','value'=>$heatingMap[$ad->heating_type] ?? ($ad->heating_type ?? '-')],
                ['icon'=>'fa-elevator','label'=>'مصعد','value'=>$ad->has_elevator ? 'نعم' : 'لا'],
                ['icon'=>'fa-parking','label'=>'موقف سيارات','value'=>$ad->has_parking ? 'نعم' : 'لا'],
            ];
        ?>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 text-sm">
            <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="flex items-center justify-between border-b border-gray-100 py-1">
                    <div class="flex items-center gap-2">
                        <i class="fas <?php echo e($f['icon']); ?> text-gray-500 w-5 text-center"></i>
                        <span class="text-gray-900 font-medium"><?php echo e($f['label']); ?>:</span>
                    </div>
                    <span class="text-red-600 font-semibold"><?php echo e($f['value']); ?></span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>


<?php elseif(in_array($cat, ['سيارات','سيارة','cars','car','vehicle'])): ?>
<div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6 mt-6">
    <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-900 dark:text-gray-100 border-b pb-2">
        <i class="fas fa-car text-yellow-500"></i> تفاصيل السيارة
    </h2>

    <?php
        $colors = [
            'White'=>'أبيض','Black'=>'أسود','Gray'=>'رمادي','Silver'=>'فضي','Blue'=>'أزرق','Red'=>'أحمر',
            'Gold'=>'ذهبي','Green'=>'أخضر','Brown'=>'بني','Beige'=>'بيج','Orange'=>'برتقالي','Yellow'=>'أصفر'
        ];
        $dealMap = ['sale'=>'بيع','rent'=>'إيجار','lease'=>'إيجار','بيع'=>'بيع','إيجار'=>'إيجار'];
    ?>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 text-sm">
        <?php
            $fields = [
                ['icon'=>'fa-industry','label'=>'الشركة المصنعة','value'=>$ad->car_brand ?? '-'],
                ['icon'=>'fa-car-side','label'=>'الموديل','value'=>$ad->car_model ?? '-'],
                ['icon'=>'fa-calendar-alt','label'=>'سنة الصنع','value'=>$ad->car_year ?? '-'],
                ['icon'=>'fa-gas-pump','label'=>'نوع الوقود','value'=>match($ad->fuel ?? '') {
                    'Petrol'=>'بنزين','Diesel'=>'ديزل','Electric'=>'كهرباء','Hybrid'=>'هجين', default=>$ad->fuel ?? '-'
                }],
                ['icon'=>'fa-cogs','label'=>'ناقل الحركة','value'=>match($ad->gearbox ?? '') {
                    'Automatic'=>'أوتوماتيك','Manual'=>'عادي', default=>$ad->gearbox ?? '-'
                }],
                ['icon'=>'fa-palette','label'=>'اللون','value'=>$colors[$ad->car_color] ?? $ad->car_color ?? '-'],
                ['icon'=>'fa-tachometer-alt','label'=>'عدد الكيلومترات','value'=>$ad->car_km ? number_format($ad->car_km).' كم' : '-'],
                ['icon'=>'fa-bolt','label'=>'سعة المحرك','value'=>$ad->engine_size ? $ad->engine_size.' سم³' : '-'],
                ['icon'=>'fa-door-closed','label'=>'عدد الأبواب','value'=>$ad->doors ?? '-'],
                ['icon'=>'fa-car-crash','label'=>'نوع الهيكل','value'=>$ad->body_type ?? '-'],
                ['icon'=>'fa-tags','label'=>'نوع العرض','value'=>$dealLabel],
                ['icon'=>'fa-flag-checkered','label'=>'الحالة','value'=>$ad->is_new ? '🚗 جديدة' : '🔧 مستعملة'],
            ];
        ?>

        <?php $__currentLoopData = $fields; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="flex items-center justify-between border-b border-gray-100 py-1">
            <div class="flex items-center gap-2">
                <i class="fas <?php echo e($f['icon']); ?> text-gray-500 w-5 text-center"></i>
                <span class="text-gray-900 font-medium"><?php echo e($f['label']); ?>:</span>
            </div>
            <span class="text-red-600 font-semibold"><?php echo e($f['value']); ?></span>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


<?php elseif(in_array($cat, ['خدمات','services'])): ?>

    <?php
        $serviceTypes = [
            'maintenance' => 'صيانة عامة',
            'cleaning' => 'تنظيف منازل ومكاتب',
            'moving' => 'نقل أثاث',
            'gardening' => 'تنسيق حدائق',
            'pets' => 'رعاية الحيوانات',

            'car-mechanic' => 'ميكانيك سيارات',
            'car-electric' => 'كهرباء سيارات',
            'car-wash' => 'غسيل سيارات',
            'cargo' => 'نقل بضائع',
            'driver' => 'سائق خاص',

            'private-lessons' => 'دروس خصوصية',
            'programming' => 'كورسات برمجة',
            'languages' => 'تعليم لغات',
            'music' => 'تعليم موسيقى',
            'fitness' => 'تدريب رياضي',

            'dentists' => 'أطباء أسنان',
            'clinics' => 'عيادات وصيدليات',
            'barbers' => 'صالونات حلاقة',
            'beauty' => 'مراكز تجميل',
            'massage' => 'مساج وعلاج طبيعي',

            'lawyers' => 'محاماة',
            'accounting' => 'محاسبة',
            'marketing' => 'تسويق رقمي',
            'design' => 'تصميم وغرافيك',
            'photography' => 'تصوير ومونتاج',

            'university' => 'تسجيل جامعي',
            'translation' => 'ترجمة',
            'research' => 'كتابة أبحاث',
            'documents' => 'تخليص معاملات',
        ];

        $serviceLabel = $serviceTypes[$ad->service_type] ?? 'خدمة';
    ?>

    <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
        <h2 class="text-lg font-bold mb-4 flex items-center gap-2 text-gray-800 dark:text-gray-100 border-b pb-2">
            <i class="fas fa-tools text-yellow-500"></i> تفاصيل الخدمة
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 text-sm text-gray-700 dark:text-gray-200">

            <div class="flex items-center justify-between border-b border-gray-200 pb-1">
                <span><i class="fas fa-wrench text-gray-500"></i> نوع الخدمة:</span>
                <span class="font-bold text-red-600"><?php echo e($serviceLabel); ?></span>
            </div>

            <div class="flex items-center justify-between border-b border-gray-200 pb-1">
                <span><i class="fas fa-user-tag text-gray-500"></i> اسم المزود:</span>
                <span class="font-bold text-gray-800 dark:text-gray-100"><?php echo e($ad->provider_name ?? '-'); ?></span>
            </div>
        </div>
    </div>


<?php else: ?>
    <p><i class="fas fa-folder-open text-gray-500"></i> <?php echo e($ad->category); ?></p>
<?php endif; ?>
</div>
                
<div x-show="tab==='description'" class="text-gray-700 dark:text-gray-200 leading-relaxed">
                    <?php echo e($ad->description ?: __('messages.no_description')); ?>

                </div>
                
                <div x-show="tab==='map'" class="mt-4">
                  <div id="map" class="w-full h-[400px] md:h-[500px] rounded-lg shadow"></div>
                </div>
            </div>

<div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mt-6">
    
    <a href="tel:<?php echo e($ad->user->phone ?? ''); ?>" 
       class="btn-yellow bg-green-500 hover:bg-green-600 w-full text-center">
        <i class="fas fa-phone"></i> <?php echo e(__('messages.call')); ?>

    </a>
<?php if(auth()->guard()->check()): ?>
    <?php if(auth()->user()->favorites()->where('ad_id', $ad->id)->exists()): ?>
        
        <form method="POST" action="<?php echo e(route('ads.unfavorite', $ad->slug)); ?>" class="w-full">
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
            <button type="submit" class="btn-yellow bg-red-500 hover:bg-red-600 w-full text-center">
                <i class="fas fa-heart-broken"></i> <?php echo e(__('messages.remove_favorite')); ?>

            </button>
        </form>
    <?php else: ?>
        
        <form method="POST" action="<?php echo e(route('ads.favorite', $ad->slug)); ?>" class="w-full">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn-yellow bg-yellow-500 hover:bg-yellow-600 w-full text-center">
                <i class="fas fa-heart"></i> <?php echo e(__('messages.add_to_favorite')); ?>

            </button>
        </form>
    <?php endif; ?>
<?php endif; ?>

    <button onclick="shareAd('<?php echo e(route('ads.show', $ad->slug)); ?>')" 
            class="btn-yellow bg-yellow-500 hover:bg-yellow-600 w-full text-center">
        <i class="fas fa-share-alt"></i> <?php echo e(__('messages.share')); ?>

    </button>
</div>

<script>
function shareAd(url) {
    if (navigator.share) {
        navigator.share({
            title: document.title,
            text: 'شاهد هذا الإعلان على Delni.co',
            url: url,
        }).catch(err => console.log(err));
    } else {
        navigator.clipboard.writeText(url);
        alert("تم نسخ رابط الإعلان ✅");
    }
}
</script>
    
    <div class="mt-12">
<h2 class="text-xl font-bold mb-4 text-gray-800 dark:text-gray-100">
    <i class="fas fa-search"></i> <?php echo e(__('messages.related_ads')); ?>

</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <?php $__currentLoopData = $relatedAds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $imgs = is_array($item->images) ? $item->images : json_decode($item->images, true);
                    $img  = !empty($imgs[0]) ? asset('storage/'.$imgs[0]) : asset('storage/placeholder.png');
                ?>
                    <a href="<?php echo e(route('ads.show', $item->slug)); ?>" class="block bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg overflow-hidden">
                    <img src="<?php echo e($img); ?>" class="w-full h-40 object-cover" alt="related">
                    <div class="p-3">
<h3 class="font-bold truncate text-gray-800 dark:text-gray-100"><?php echo e($item->title); ?></h3>
<p class="text-sm text-gray-500 dark:text-gray-300">
    <i class="fas fa-map-marker-alt"></i> <?php echo e($item->city); ?>

</p>
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
let map;
document.addEventListener("DOMContentLoaded", function () {
    var lat = <?php echo e($ad->lat ?? 41.0672); ?>;
    var lng = <?php echo e($ad->lng ?? 28.7994); ?>;
    map = L.map('map').setView([lat, lng], 13);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(map);
            L.marker([lat, lng]).addTo(map)
                .bindPopup("📍 موقع الإعلان")
                .openPopup();
        });
        function shareAd(url) {
            if (navigator.share) {
                navigator.share({ title: document.title, text: 'شاهد هذا الإعلان على Delni.co', url: url });
            } else {
                navigator.clipboard.writeText(url);
                alert("تم نسخ رابط الإعلان ✅");
            }
        }
    </script>
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
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
<?php /**PATH /home/delni_user/delni/resources/views/ads/show.blade.php ENDPATH**/ ?>