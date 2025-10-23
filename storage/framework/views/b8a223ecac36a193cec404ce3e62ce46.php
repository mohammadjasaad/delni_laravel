<?php $__env->startSection('title', 'Forbidden'); ?>
<?php $__env->startSection('code', '403'); ?>
<?php $__env->startSection('message', __('messages.error_403_message', [], app()->getLocale()) ?? 'Access denied'); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/delni_user/delni/resources/views/errors/403.blade.php ENDPATH**/ ?>