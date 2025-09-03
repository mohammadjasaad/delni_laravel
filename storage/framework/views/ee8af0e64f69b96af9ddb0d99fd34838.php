
<footer class="bg-white dark:bg-gray-900 border-t mt-12">
    <div class="max-w-7xl mx-auto px-4 py-8 grid grid-cols-1 md:grid-cols-3 gap-8 text-center md:text-right">

        
        <div class="flex flex-col items-center md:items-start space-y-3">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                <img src="<?php echo e(asset('images/delnilogo.png')); ?>" alt="Delni Logo" class="h-10">
                <span class="text-lg font-bold text-gray-800 dark:text-gray-100">Delni.co</span>
            </a>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                <?php echo e(__('messages.footer_about', ['app' => 'Delni.co'])); ?>

            </p>
        </div>

        
        <div>
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3"><?php echo e(__('messages.quick_links')); ?></h3>
            <ul class="space-y-2 text-sm">
                <li><a href="<?php echo e(route('home')); ?>" class="hover:text-yellow-500"><?php echo e(__('messages.home')); ?></a></li>
                <li><a href="<?php echo e(route('about')); ?>" class="hover:text-yellow-500"><?php echo e(__('messages.about')); ?></a></li>
                <li><a href="<?php echo e(route('contact')); ?>" class="hover:text-yellow-500"><?php echo e(__('messages.contact')); ?></a></li>
<li><a href="<?php echo e(route('terms')); ?>" class="hover:text-yellow-500"><?php echo e(__('messages.terms_conditions')); ?></a></li>
<li><a href="<?php echo e(route('privacy')); ?>" class="hover:text-yellow-500"><?php echo e(__('messages.privacy_policy')); ?></a></li>
<li><a href="<?php echo e(route('faq')); ?>" class="hover:text-yellow-500"><?php echo e(__('messages.faq_title')); ?></a></li>
            </ul>
        </div>

        
        <div>
            <h3 class="font-semibold text-gray-700 dark:text-gray-300 mb-3"><?php echo e(__('messages.contact_us')); ?></h3>
            <ul class="space-y-2 text-sm">
                <li>📞 <a href="tel:+963988779548" class="hover:text-yellow-500">+963 988 779 548</a></li>
                <li>💬 <a href="https://wa.me/963988779548" target="_blank" class="hover:text-green-500">WhatsApp</a></li>
                <li>✉️ <a href="mailto:info@delni.co" class="hover:text-yellow-500">info@delni.co</a></li>
            </ul>
        </div>
    </div>

    
    <div class="bg-gray-100 dark:bg-gray-800 text-center py-3 text-sm text-gray-600 dark:text-gray-400">
        © <?php echo e(date('Y')); ?> Delni.co — <?php echo e(__('messages.all_rights_reserved')); ?>

    </div>
</footer>
<?php /**PATH /home/delni_user/delni/resources/views/partials/footer.blade.php ENDPATH**/ ?>