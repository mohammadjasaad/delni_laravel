<?php $__env->startSection('title', 'Page Expired'); ?>
<?php $__env->startSection('code', '419'); ?>
<?php $__env->startSection('message', __('messages.error_419_message', [], app()->getLocale()) ?? 'Session expired, please refresh'); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/delni_user/delni/resources/views/errors/419.blade.php ENDPATH**/ ?>