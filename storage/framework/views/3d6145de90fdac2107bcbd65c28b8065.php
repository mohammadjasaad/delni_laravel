
<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\AppLayout::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['isAdmin' => true]); ?>
    <div class="max-w-7xl mx-auto py-10 px-6">
        
        
        <h1 class="text-3xl font-extrabold text-yellow-600 mb-8 text-center">
            🛠️ <?php echo e(__('messages.admin_dashboard')); ?>

        </h1>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-6 mb-12">
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '👤','label' => ''.e(__('messages.users_count')).'','value' => ''.e($userCount).'','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '👤','label' => ''.e(__('messages.users_count')).'','value' => ''.e($userCount).'','color' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '📢','label' => ''.e(__('messages.ads_count')).'','value' => ''.e($adCount).'','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '📢','label' => ''.e(__('messages.ads_count')).'','value' => ''.e($adCount).'','color' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '⭐','label' => ''.e(__('messages.featured_ads_count')).'','value' => ''.e($featuredAdsCount).'','color' => 'yellow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '⭐','label' => ''.e(__('messages.featured_ads_count')).'','value' => ''.e($featuredAdsCount).'','color' => 'yellow']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '🚨','label' => ''.e(__('messages.emergency_reports_count')).'','value' => ''.e($reportCount).'','color' => 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '🚨','label' => ''.e(__('messages.emergency_reports_count')).'','value' => ''.e($reportCount).'','color' => 'red']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '👁️','label' => ''.e(__('messages.visitors_count')).'','value' => ''.e($visitorsCount).'','color' => 'purple']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '👁️','label' => ''.e(__('messages.visitors_count')).'','value' => ''.e($visitorsCount).'','color' => 'purple']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '🚖','label' => ''.e(__('messages.drivers_count')).'','value' => ''.e($driversCount).'','color' => 'indigo']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '🚖','label' => ''.e(__('messages.drivers_count')).'','value' => ''.e($driversCount).'','color' => 'indigo']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        </div>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-5 gap-6 mb-12">
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '🎫','label' => ''.e(__('messages.tickets_total')).'','value' => ''.e($ticketsTotal).'','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '🎫','label' => ''.e(__('messages.tickets_total')).'','value' => ''.e($ticketsTotal).'','color' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '🆕','label' => ''.e(__('messages.ticket_status_new')).'','value' => ''.e($ticketsNew).'','color' => 'yellow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '🆕','label' => ''.e(__('messages.ticket_status_new')).'','value' => ''.e($ticketsNew).'','color' => 'yellow']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '⚙️','label' => ''.e(__('messages.ticket_status_processing')).'','value' => ''.e($ticketsProcessing).'','color' => 'orange']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '⚙️','label' => ''.e(__('messages.ticket_status_processing')).'','value' => ''.e($ticketsProcessing).'','color' => 'orange']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '✅','label' => ''.e(__('messages.ticket_status_answered')).'','value' => ''.e($ticketsAnswered).'','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '✅','label' => ''.e(__('messages.ticket_status_answered')).'','value' => ''.e($ticketsAnswered).'','color' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.stat-card','data' => ['icon' => '🚫','label' => ''.e(__('messages.ticket_status_closed')).'','value' => ''.e($ticketsClosed).'','color' => 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => '🚫','label' => ''.e(__('messages.ticket_status_closed')).'','value' => ''.e($ticketsClosed).'','color' => 'red']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $attributes = $__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__attributesOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6)): ?>
<?php $component = $__componentOriginal3c3cb599308b2d9971dae437d0b6bab6; ?>
<?php unset($__componentOriginal3c3cb599308b2d9971dae437d0b6bab6); ?>
<?php endif; ?>
        </div>

        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <?php if (isset($component)) { $__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823 = $attributes; } ?>
<?php $component = App\View\Components\Admin\ChartCard::resolve(['id' => 'userGrowthChart','title' => ''.e(__('messages.user_growth')).'','labels' => $userGrowth->keys(),'data' => $userGrowth->values()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.chart-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin\ChartCard::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823)): ?>
<?php $attributes = $__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823; ?>
<?php unset($__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823)): ?>
<?php $component = $__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823; ?>
<?php unset($__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823); ?>
<?php endif; ?>

            <?php if (isset($component)) { $__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823 = $attributes; } ?>
<?php $component = App\View\Components\Admin\ChartCard::resolve(['id' => 'adGrowthChart','title' => ''.e(__('messages.ad_growth')).'','labels' => $adGrowth->keys(),'data' => $adGrowth->values()] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.chart-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin\ChartCard::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823)): ?>
<?php $attributes = $__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823; ?>
<?php unset($__attributesOriginal088a07df3dbc5c9e58dcd0c19c15e823); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823)): ?>
<?php $component = $__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823; ?>
<?php unset($__componentOriginal088a07df3dbc5c9e58dcd0c19c15e823); ?>
<?php endif; ?>
        </div>

        
        <?php if (isset($component)) { $__componentOriginal60e3f7140232db1b3408e5157b8f43d4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal60e3f7140232db1b3408e5157b8f43d4 = $attributes; } ?>
<?php $component = App\View\Components\Admin\LatestList::resolve(['title' => '📢 '.e(__('messages.latest_ads')).'','items' => $latestAds,'empty' => __('messages.no_ads'),'route' => 'ads.index'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.latest-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin\LatestList::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['viewRoute' => 'ads.show']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal60e3f7140232db1b3408e5157b8f43d4)): ?>
<?php $attributes = $__attributesOriginal60e3f7140232db1b3408e5157b8f43d4; ?>
<?php unset($__attributesOriginal60e3f7140232db1b3408e5157b8f43d4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal60e3f7140232db1b3408e5157b8f43d4)): ?>
<?php $component = $__componentOriginal60e3f7140232db1b3408e5157b8f43d4; ?>
<?php unset($__componentOriginal60e3f7140232db1b3408e5157b8f43d4); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginal60e3f7140232db1b3408e5157b8f43d4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal60e3f7140232db1b3408e5157b8f43d4 = $attributes; } ?>
<?php $component = App\View\Components\Admin\LatestList::resolve(['title' => '🎫 '.e(__('messages.latest_tickets')).'','items' => $latestTickets,'empty' => __('messages.no_tickets'),'route' => 'admin.support_tickets.index'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.latest-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin\LatestList::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['viewRoute' => 'admin.support_tickets.show']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal60e3f7140232db1b3408e5157b8f43d4)): ?>
<?php $attributes = $__attributesOriginal60e3f7140232db1b3408e5157b8f43d4; ?>
<?php unset($__attributesOriginal60e3f7140232db1b3408e5157b8f43d4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal60e3f7140232db1b3408e5157b8f43d4)): ?>
<?php $component = $__componentOriginal60e3f7140232db1b3408e5157b8f43d4; ?>
<?php unset($__componentOriginal60e3f7140232db1b3408e5157b8f43d4); ?>
<?php endif; ?>

        
        <?php if (isset($component)) { $__componentOriginal60e3f7140232db1b3408e5157b8f43d4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal60e3f7140232db1b3408e5157b8f43d4 = $attributes; } ?>
<?php $component = App\View\Components\Admin\LatestList::resolve(['title' => '👁️ '.e(__('messages.latest_visitors')).'','items' => $latestVisitors,'empty' => __('messages.no_visitors'),'route' => 'admin.visitors.index'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.latest-list'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\Admin\LatestList::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal60e3f7140232db1b3408e5157b8f43d4)): ?>
<?php $attributes = $__attributesOriginal60e3f7140232db1b3408e5157b8f43d4; ?>
<?php unset($__attributesOriginal60e3f7140232db1b3408e5157b8f43d4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal60e3f7140232db1b3408e5157b8f43d4)): ?>
<?php $component = $__componentOriginal60e3f7140232db1b3408e5157b8f43d4; ?>
<?php unset($__componentOriginal60e3f7140232db1b3408e5157b8f43d4); ?>
<?php endif; ?>

        
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-12">
            <?php if (isset($component)) { $__componentOriginald02641715e315013ce07062c106a0539 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald02641715e315013ce07062c106a0539 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.quick-link','data' => ['route' => 'admin.users.index','icon' => '👤','label' => ''.e(__('messages.manage_users')).'','color' => 'blue']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.quick-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.users.index','icon' => '👤','label' => ''.e(__('messages.manage_users')).'','color' => 'blue']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald02641715e315013ce07062c106a0539)): ?>
<?php $attributes = $__attributesOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__attributesOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald02641715e315013ce07062c106a0539)): ?>
<?php $component = $__componentOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__componentOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald02641715e315013ce07062c106a0539 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald02641715e315013ce07062c106a0539 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.quick-link','data' => ['route' => 'admin.support_tickets.index','icon' => '🎫','label' => ''.e(__('messages.support_tickets')).'','color' => 'green']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.quick-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.support_tickets.index','icon' => '🎫','label' => ''.e(__('messages.support_tickets')).'','color' => 'green']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald02641715e315013ce07062c106a0539)): ?>
<?php $attributes = $__attributesOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__attributesOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald02641715e315013ce07062c106a0539)): ?>
<?php $component = $__componentOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__componentOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald02641715e315013ce07062c106a0539 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald02641715e315013ce07062c106a0539 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.quick-link','data' => ['route' => 'admin.emergency_reports.index','icon' => '🚨','label' => ''.e(__('messages.manage_emergency_reports')).'','color' => 'red']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.quick-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.emergency_reports.index','icon' => '🚨','label' => ''.e(__('messages.manage_emergency_reports')).'','color' => 'red']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald02641715e315013ce07062c106a0539)): ?>
<?php $attributes = $__attributesOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__attributesOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald02641715e315013ce07062c106a0539)): ?>
<?php $component = $__componentOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__componentOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald02641715e315013ce07062c106a0539 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald02641715e315013ce07062c106a0539 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.quick-link','data' => ['route' => 'admin.visitors.index','icon' => '👁️','label' => ''.e(__('messages.visitors')).'','color' => 'purple']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.quick-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.visitors.index','icon' => '👁️','label' => ''.e(__('messages.visitors')).'','color' => 'purple']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald02641715e315013ce07062c106a0539)): ?>
<?php $attributes = $__attributesOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__attributesOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald02641715e315013ce07062c106a0539)): ?>
<?php $component = $__componentOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__componentOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginald02641715e315013ce07062c106a0539 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald02641715e315013ce07062c106a0539 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.admin.quick-link','data' => ['route' => 'admin.statistics','icon' => '📊','label' => ''.e(__('messages.statistics')).'','color' => 'yellow']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('admin.quick-link'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['route' => 'admin.statistics','icon' => '📊','label' => ''.e(__('messages.statistics')).'','color' => 'yellow']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald02641715e315013ce07062c106a0539)): ?>
<?php $attributes = $__attributesOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__attributesOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald02641715e315013ce07062c106a0539)): ?>
<?php $component = $__componentOriginald02641715e315013ce07062c106a0539; ?>
<?php unset($__componentOriginald02641715e315013ce07062c106a0539); ?>
<?php endif; ?>
        </div>
    </div>

    
    <?php echo app('Illuminate\Foundation\Vite')('resources/js/admin-dashboard.js'); ?>
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
<?php /**PATH /home/delni_user/delni/resources/views/admin/dashboard/index.blade.php ENDPATH**/ ?>