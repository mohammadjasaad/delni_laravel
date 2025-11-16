<header class="bg-white dark:bg-gray-900 shadow-sm relative z-[2000] !py-0">
    <div class="max-w-7xl mx-auto px-4 py-1 flex items-center justify-between">

        
        <div class="flex items-center gap-2">
            <a href="<?php echo e(route('home')); ?>" class="flex items-center gap-2">
                <img src="<?php echo e(asset('images/delnilogo.png')); ?>" alt="Delni Logo" class="h-9">
                <span class="text-xl font-bold text-gray-800 dark:text-gray-100">Delni.co</span>
            </a>
        </div>

        
        <nav class="hidden md:flex gap-6 text-sm font-medium text-gray-700 dark:text-gray-300">
        </nav>

        
        <div class="hidden md:flex items-center gap-3">
            
            <?php if(auth()->check() && auth()->user()->role !== 'admin'): ?>
                <a href="<?php echo e(route('ads.create')); ?>"
                   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                          text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                    ➕ <?php echo e(__('messages.add_ad')); ?>

                </a>
            <?php endif; ?>

            
            <?php if(auth()->guard()->check()): ?>
                <?php
                    $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
                ?>
                <?php if($userStore): ?>
                    <a href="<?php echo e(route('mall.dashboard', $userStore->id)); ?>"
                       class="px-3 py-1.5 rounded bg-yellow-400 text-black font-semibold shadow hover:bg-yellow-500 transition text-sm flex items-center gap-1">
                        <i class="fas fa-store"></i> <?php echo e(__('mall.my_store')); ?>

                    </a>
                <?php endif; ?>
            <?php endif; ?>

            
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'admin'): ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>"
                       class="px-3 py-1.5 rounded bg-yellow-500 text-white hover:bg-yellow-600 text-sm">
                        🛠️ <?php echo e(__('messages.admin_panel')); ?>

                    </a>
                <?php else: ?>
                    <a href="<?php echo e(route('dashboard.index')); ?>"
                       class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                              text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                        👤 <?php echo e(__('messages.dashboard')); ?>

                    </a>
                <?php endif; ?>

                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit"
                            class="px-3 py-1.5 rounded bg-red-500 text-white hover:bg-red-600 text-sm">
                        🚪 <?php echo e(__('messages.logout')); ?>

                    </button>
                </form>
            <?php else: ?>
<a href="<?php echo e(route('login')); ?>"
   class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
          text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
    👤 <?php echo e(__('messages.login')); ?>

</a>
            <?php endif; ?>

            
            <a href="<?php echo e(route('change.lang', app()->getLocale() === 'ar' ? 'en' : 'ar')); ?>"
               class="px-3 py-1.5 rounded bg-gray-100 dark:bg-gray-800 
                      text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700 text-sm">
                🌐 <?php echo e(app()->getLocale() === 'ar' ? __('messages.lang_en') : __('messages.lang_ar')); ?>

            </a>

            
            <button id="toggleDarkModeDesktop"
                    class="px-3 py-1.5 rounded bg-gray-200 dark:bg-gray-700 
                           text-gray-800 dark:text-gray-200 hover:scale-105 transition text-sm">
                🌙
            </button>
        </div>

        
        <div class="md:hidden flex items-center gap-2">
            
            <button id="toggleDarkModeMobile"
                    class="p-2 rounded bg-gray-200 dark:bg-gray-700 
                           text-gray-800 dark:text-gray-200 hover:scale-105 transition">
                🌙
            </button>

            
            <button id="mobileMenuBtn"
                    class="p-2 rounded bg-gray-100 dark:bg-gray-800">
                ☰
            </button>
        </div>
    </div>

    
    <div id="mobileMenu"
         class="hidden md:hidden absolute top-full left-0 w-full bg-white dark:bg-gray-900 border-t p-4 space-y-3 shadow-lg z-50">
        <a href="<?php echo e(route('home')); ?>" class="block hover:text-yellow-500"><?php echo e(__('messages.home')); ?></a>

        <?php if(auth()->check() && auth()->user()->role !== 'admin'): ?>
            <a href="<?php echo e(route('ads.create')); ?>" class="block hover:text-yellow-500">➕ <?php echo e(__('messages.add_ad')); ?></a>
        <?php endif; ?>

        
        <?php if(auth()->guard()->check()): ?>
            <?php
                $userStore = \App\Models\Store::where('user_id', auth()->id())->first();
            ?>
            <?php if($userStore): ?>
                <a href="<?php echo e(route('mall.dashboard', $userStore->id)); ?>" class="block hover:text-yellow-500">
                    <i class="fas fa-store"></i> <?php echo e(__('mall.my_store')); ?>

                </a>
            <?php endif; ?>
        <?php endif; ?>

        <?php if(auth()->guard()->check()): ?>
            <?php if(auth()->user()->role === 'admin'): ?>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="block hover:text-yellow-500">🛠️ <?php echo e(__('messages.admin_panel')); ?></a>
            <?php else: ?>
                <a href="<?php echo e(route('dashboard.index')); ?>" class="block hover:text-yellow-500">👤 <?php echo e(__('messages.dashboard')); ?></a>
            <?php endif; ?>

            <form action="<?php echo e(route('logout')); ?>" method="POST" class="mt-2">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full text-left text-red-600 hover:text-red-700">
                    🚪 <?php echo e(__('messages.logout')); ?>

                </button>
            </form>
        <?php else: ?>
<a href="<?php echo e(route('login')); ?>" class="block hover:text-yellow-500">
    👤 <?php echo e(__('messages.login')); ?>

</a>

        <a href="<?php echo e(route('change.lang', app()->getLocale() === 'ar' ? 'en' : 'ar')); ?>"
           class="block hover:text-yellow-500">
            🌐 <?php echo e(app()->getLocale() === 'ar' ? 'English' : 'العربية'); ?>

        </a>
    </div>
<?php endif; ?>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const btn = document.getElementById("mobileMenuBtn");
            const menu = document.getElementById("mobileMenu");
            btn.addEventListener("click", () => {
                menu.classList.toggle("hidden");
            });
        });
    </script>
</header>
<?php /**PATH /home/delni_user/delni/resources/views/partials/header.blade.php ENDPATH**/ ?>