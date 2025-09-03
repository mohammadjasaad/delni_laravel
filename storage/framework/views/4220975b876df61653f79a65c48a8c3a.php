
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
    <div class="max-w-7xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">🚨 إدارة بلاغات مراكز الطوارئ</h1>

        <?php if(session('success')): ?>
            <div class="bg-green-100 text-green-800 p-4 mb-6 rounded text-center shadow">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($reports->isEmpty()): ?>
            <div class="bg-yellow-100 text-yellow-800 p-4 rounded text-center">
                لا يوجد بلاغات حالياً.
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-xl shadow-md">
                    <thead>
                        <tr class="bg-gray-100 text-gray-700 text-sm">
                            <th class="py-3 px-4 text-right">#</th>
                            <th class="py-3 px-4 text-right">اسم المركز</th>
                            <th class="py-3 px-4 text-right">المدينة</th>
                            <th class="py-3 px-4 text-right">النوع</th>
                            <th class="py-3 px-4 text-right">الحالة</th>
                            <th class="py-3 px-4 text-right">تاريخ البلاغ</th>
                            <th class="py-3 px-4 text-right">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $reports; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $report): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $statusColors = [
                                    'pending' => 'bg-yellow-500',
                                    'processing' => 'bg-blue-500',
                                    'resolved' => 'bg-green-600',
                                    'closed' => 'bg-gray-500',
                                ];
                                $statusLabels = [
                                    'pending' => 'قيد المراجعة',
                                    'processing' => 'جارٍ المعالجة',
                                    'resolved' => 'تم الحل',
                                    'closed' => 'مغلق',
                                ];
                            ?>
                            <tr class="border-t hover:bg-gray-50 text-sm">
                                <td class="py-2 px-4"><?php echo e($index + 1); ?></td>
                                <td class="py-2 px-4"><?php echo e($report->service->name ?? 'غير متوفر'); ?></td>
                                <td class="py-2 px-4"><?php echo e($report->service->city ?? '—'); ?></td>
                                <td class="py-2 px-4"><?php echo e($report->service->type ?? '—'); ?></td>
                                <td class="py-2 px-4">
                                    <span class="px-2 py-1 rounded text-white text-xs font-semibold <?php echo e($statusColors[$report->status] ?? 'bg-gray-400'); ?>">
                                        <?php echo e($statusLabels[$report->status] ?? $report->status); ?>

                                    </span>
                                </td>
                                <td class="py-2 px-4"><?php echo e($report->created_at->format('Y-m-d H:i')); ?></td>
                                <td class="py-2 px-4 text-center">
                                    <div class="flex justify-center items-center space-x-2 rtl:space-x-reverse">
                                        <a href="<?php echo e(route('admin.emergency_reports.show', $report->id)); ?>"
                                           class="text-blue-600 hover:underline text-sm">📋 تفاصيل</a>

                                        <form method="POST" action="<?php echo e(route('admin.emergency_reports.destroy', $report->id)); ?>"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا البلاغ؟')">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="text-red-600 hover:underline text-sm">🗑️ حذف</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="mt-6">
                <?php echo e($reports->links()); ?>

            </div>
        <?php endif; ?>
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
<?php /**PATH /home/delni_user/delni/resources/views/admin/emergency_reports/index.blade.php ENDPATH**/ ?>