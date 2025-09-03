
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
        <h1 class="text-3xl font-bold mb-6 text-gray-800">🎫 إدارة تذاكر الدعم الفني</h1>

        
        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4 text-center">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full text-sm text-gray-800">
                <thead class="bg-gray-100 text-gray-600 font-semibold text-right">
                    <tr>
                        <th class="px-4 py-3">#</th>
                        <th class="px-4 py-3">المستخدم</th>
                        <th class="px-4 py-3">الموضوع</th>
                        <th class="px-4 py-3">الحالة</th>
                        <th class="px-4 py-3">التاريخ</th>
                        <th class="px-4 py-3">التحكم</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $tickets; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ticket): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="border-t hover:bg-gray-50">
                            <td class="px-4 py-3"><?php echo e($ticket->id); ?></td>
                            <td class="px-4 py-3"><?php echo e($ticket->user->name ?? 'غير معروف'); ?></td>
                            <td class="px-4 py-3 font-medium text-gray-900"><?php echo e($ticket->subject); ?></td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-white text-xs font-bold
                                    <?php echo e($ticket->status === 'جديد' ? 'bg-yellow-500' : 
                                       ($ticket->status === 'قيد المعالجة' ? 'bg-blue-500' : 
                                       ($ticket->status === 'تم الرد' ? 'bg-green-500' : 'bg-gray-500'))); ?>">
                                    <?php echo e($ticket->status); ?>

                                </span>
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                <?php echo e($ticket->created_at->translatedFormat('Y/m/d - h:i A')); ?>

                            </td>
                            <td class="px-4 py-3">
                                <a href="<?php echo e(route('admin.support_tickets.show', $ticket->id)); ?>"
                                   class="text-indigo-600 hover:underline font-semibold">👁️ عرض</a>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="6" class="text-center py-6 text-gray-500">لا توجد تذاكر دعم حتى الآن.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
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
<?php /**PATH /home/delni_user/delni/resources/views/admin/support_tickets/index.blade.php ENDPATH**/ ?>