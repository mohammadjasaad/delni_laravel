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
    <div class="max-w-6xl mx-auto py-10 px-4">

        
        <h1 class="text-3xl font-bold text-gray-800 mb-6"><?php echo e(__('messages.dashboard')); ?></h1>

        
        <div class="mb-6 p-4 bg-yellow-100 border-l-4 border-yellow-500 text-yellow-800 rounded">
            <?php echo e(__('messages.welcome')); ?> <?php echo e(Auth::user()->name); ?> 👋
        </div>

        
        <div class="flex flex-wrap gap-4 justify-center mb-10">
            <a href="<?php echo e(route('dashboard.favorites')); ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-6 py-2 rounded shadow">
                ❤️ <?php echo e(__('messages.my_favorites')); ?>

            </a>
            <a href="<?php echo e(route('dashboard.myorders')); ?>" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded shadow">
                🚖 <?php echo e(__('messages.my_orders')); ?>

            </a>
        </div>

        
        <?php if(auth()->user()->notifications->count()): ?>
            <div class="mb-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-3">🔔 إشعاراتك</h2>
                <ul class="space-y-2">
                    <?php $__currentLoopData = auth()->user()->notifications; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notification): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li class="bg-white border rounded p-3 text-sm text-gray-700 shadow flex justify-between items-center">
                            <span><?php echo e($notification->data['message']); ?></span>
                            <span class="text-xs text-gray-400"><?php echo e($notification->created_at->diffForHumans()); ?></span>
                        </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </div>
        <?php endif; ?>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'dashboard.ads.create','icon' => '➕','title' => ''.e(__('messages.add_new_ad')).'','desc' => ''.e(__('messages.add_new_ad_description')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'dashboard.myads','icon' => '📢','title' => ''.e(__('messages.my_ads')).'','desc' => ''.e(__('messages.view_manage_ads')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'dashboard.myinfo','icon' => '👤','title' => ''.e(__('messages.my_info')).'','desc' => ''.e(__('messages.view_edit_info')).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'dashboard.editpassword','icon' => '🔐','title' => ''.e(__('messages.change_password')).'','desc' => 'تحديث كلمة مرور حسابك بأمان.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'dashboard.statistics','icon' => '📊','title' => 'إحصائيات الموقع','desc' => 'عرض ملخص بيانات المستخدمين والإعلانات والخدمات.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'emergency_reports.index','icon' => '📋','title' => 'بلاغات الطوارئ','desc' => 'عرض ومراجعة جميع البلاغات المرسلة من المستخدمين.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>

            
            <?php if (isset($component)) { $__componentOriginal1a354a0ebe653056897bd6d29eb968e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1 = $attributes; } ?>
<?php $component = App\View\Components\Dashboard\Card::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('dashboard.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Dashboard\Card::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'emergency.stats','icon' => '🆘','title' => 'إحصائيات الطوارئ','desc' => 'معلومات حول المراكز والبلاغات الأكثر نشاطًا.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $attributes = $__attributesOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__attributesOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1)): ?>
<?php $component = $__componentOriginal1a354a0ebe653056897bd6d29eb968e1; ?>
<?php unset($__componentOriginal1a354a0ebe653056897bd6d29eb968e1); ?>
<?php endif; ?>
        </div>

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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/index.blade.php ENDPATH**/ ?>