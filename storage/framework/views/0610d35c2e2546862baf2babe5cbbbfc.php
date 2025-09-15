
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
        
        
        <h1 class="text-3xl font-bold text-yellow-600 mb-8 text-center">
            👥 <?php echo e(__('messages.manage_users')); ?>

        </h1>

        
        <div class="mb-6 flex justify-end">
            <form method="GET" action="<?php echo e(route('admin.users.index')); ?>" class="flex gap-2">
                <select name="role" onchange="this.form.submit()" 
                        class="border-gray-300 rounded-lg shadow-sm px-3 py-2 text-sm">
                    <option value=""><?php echo e(__('messages.all')); ?></option>
                    <option value="user" <?php if(request('role')==='user'): ?> selected <?php endif; ?>>
                        <?php echo e(__('messages.user')); ?>

                    </option>
                    <option value="admin" <?php if(request('role')==='admin'): ?> selected <?php endif; ?>>
                        <?php echo e(__('messages.admin')); ?>

                    </option>
                </select>
            </form>
        </div>

        
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full border border-gray-200 divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold"><?php echo e(__('messages.name')); ?></th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold"><?php echo e(__('messages.email')); ?></th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold"><?php echo e(__('messages.role')); ?></th>
                        <th class="px-4 py-2 text-left text-gray-600 font-semibold"><?php echo e(__('messages.registered_since')); ?></th>
                        <th class="px-4 py-2 text-center text-gray-600 font-semibold"><?php echo e(__('messages.actions')); ?></th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr>
                            <td class="px-4 py-2 text-gray-800 font-medium"><?php echo e($user->name); ?></td>
                            <td class="px-4 py-2 text-gray-700"><?php echo e($user->email); ?></td>
                            <td class="px-4 py-2">
                                <?php if($user->role === 'admin'): ?>
                                    <span class="text-red-600 font-bold"><?php echo e(__('messages.admin')); ?></span>
                                <?php else: ?>
                                    <span class="text-gray-700"><?php echo e(__('messages.user')); ?></span>
                                <?php endif; ?>
                            </td>
                            <td class="px-4 py-2 text-gray-600"><?php echo e($user->created_at->diffForHumans()); ?></td>
                            <td class="px-4 py-2 text-center">
                                <?php if($user->role !== 'admin'): ?>
                                    <form action="<?php echo e(route('admin.users.promote', $user->id)); ?>" 
                                          method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded shadow text-xs">
                                            ⭐ <?php echo e(__('messages.promote_to_admin')); ?>

                                        </button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-green-600 font-semibold"><?php echo e(__('messages.already_admin')); ?></span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="px-4 py-4 text-center text-gray-500">
                                <?php echo e(__('messages.no_users_found')); ?>

                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        
        <div class="mt-6">
            <?php echo e($users->links()); ?>

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
<?php /**PATH /home/delni_user/delni/resources/views/admin/users/index.blade.php ENDPATH**/ ?>