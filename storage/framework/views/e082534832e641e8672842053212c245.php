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

    <div class="max-w-2xl mx-auto py-10 px-4">

        
        <h1 class="text-3xl font-bold mb-6"><?php echo e(__('messages.my_info')); ?></h1>

<a href="<?php echo e(route('dashboard.myinfo.edit')); ?>"
   class="mt-4 inline-block bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
   ✏️ تعديل البيانات
</a>

        
        <div class="bg-white shadow rounded p-6 space-y-4 mb-6">
            <p><strong><?php echo e(__('messages.name')); ?>:</strong> <?php echo e(Auth::user()->name); ?></p>
            <p><strong><?php echo e(__('messages.email')); ?>:</strong> <?php echo e(Auth::user()->email); ?></p>
            <p><strong><?php echo e(__('messages.registered_at')); ?>:</strong> <?php echo e(Auth::user()->created_at->diffForHumans()); ?></p>
        </div>

        
        <div class="text-right">
            <a href="<?php echo e(route('dashboard.editpassword')); ?>"
               class="inline-block bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded shadow">
                🔒 <?php echo e(__('messages.change_password')); ?>

            </a>
        </div>
<a href="<?php echo e(route('dashboard.password.change')); ?>"
   class="mt-4 inline-block bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded">
   🔐 تغيير كلمة المرور
</a>

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
<?php /**PATH /home/delni_user/delni/resources/views/dashboard/myinfo.blade.php ENDPATH**/ ?>