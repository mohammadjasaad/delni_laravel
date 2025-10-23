
<?php if($errors->any()): ?>
    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
        <div class="flex items-center text-red-700 mb-2">
            <span class="text-xl mr-2">⚠️</span>
            <h3 class="font-semibold"><?php echo e(__('messages.validation_failed')); ?></h3>
        </div>
        <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php /**PATH /home/delni_user/delni/resources/views/components/validation-errors.blade.php ENDPATH**/ ?>