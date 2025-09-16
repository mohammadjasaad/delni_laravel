
<?php $__empty_1 = true; $__currentLoopData = $ads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ad): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
    <?php
        $images = is_array($ad->images) ? $ad->images : json_decode($ad->images, true);
        $firstImage = !empty($images[0]) ? asset('storage/'.$images[0]) : asset('storage/placeholder.png');
    ?>

    <div class="ad-card relative <?php echo e($ad->is_featured ? 'border-yellow-400':'border-gray-200 dark:border-gray-700'); ?>">
        
        <?php if($ad->is_featured): ?>
            <span class="badge-featured"><i class="fas fa-star"></i></span>
        <?php endif; ?>

        
        <div class="absolute top-2 left-2 z-10">
            <?php if(auth()->guard()->check()): ?>
                <button 
                    class="favorite-btn <?php echo e(auth()->user()->favorites->contains($ad->id) ? 'text-red-600' : 'text-gray-400'); ?> hover:text-red-600 transition"
                    data-slug="<?php echo e($ad->slug); ?>">
                    <i class="<?php echo e(auth()->user()->favorites->contains($ad->id) ? 'fas' : 'far'); ?> fa-heart fa-lg"></i>
                </button>
            <?php endif; ?>
        </div>

        
        <a href="<?php echo e(route('ads.show', $ad->slug)); ?>">
            <img src="<?php echo e($firstImage); ?>" class="w-full h-48 object-cover rounded-t-xl" alt="ad">
        </a>

        
        <div class="p-4 flex flex-col justify-between flex-1">
            <h2 class="font-bold text-base truncate text-gray-900 dark:text-white"><?php echo e($ad->title); ?></h2>
            <p class="text-gray-500 dark:text-gray-400 text-sm">
                <i class="fas fa-map-marker-alt text-red-500"></i> <?php echo e($ad->city); ?>

            </p>
            <p class="text-red-600 font-bold text-sm mt-1">
                <i class="fas fa-dollar-sign"></i> <?php echo e(number_format($ad->price)); ?> <?php echo e(__('messages.currency')); ?>

            </p>
            <a href="<?php echo e(route('ads.show', $ad->slug)); ?>" class="block mt-3 text-center btn-yellow">
                <i class="fas fa-eye"></i> <?php echo e(__('messages.view_ad')); ?>

            </a>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
    <p class="text-center col-span-4 text-gray-500 mt-8">
        <i class="fas fa-exclamation-circle"></i> <?php echo e(__('messages.no_ads_found')); ?>

    </p>
<?php endif; ?>



<script>
document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".favorite-btn").forEach(btn => {
        btn.addEventListener("click", async (e) => {
            e.preventDefault();

            const slug = btn.dataset.slug;
            const token = document.querySelector('meta[name="csrf-token"]').content;

            try {
                let response = await fetch(`/ads/${slug}/toggle-favorite`, {
                    method: "POST",
                    headers: {
                        "X-CSRF-TOKEN": token,
                        "Accept": "application/json",
                    }
                });

                if (response.ok) {
                    btn.classList.toggle("text-red-600");
                    btn.classList.toggle("text-gray-400");

                    let icon = btn.querySelector("i");
                    icon.classList.toggle("fas");
                    icon.classList.toggle("far");
                } else {
                    console.error("❌ خطأ بالطلب:", response.status);
                }
            } catch (err) {
                console.error("⚠️ خطأ:", err);
            }
        });
    });
});
</script>
<?php /**PATH /home/delni_user/delni/resources/views/ads/partials/list.blade.php ENDPATH**/ ?>