<?php $__env->startSection('title', 'Page Not Found'); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('message', __('messages.error_404_message', [], app()->getLocale()) ?? 'Page not found'); ?>

<?php echo $__env->make('errors.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/delni_user/delni/resources/views/errors/404.blade.php ENDPATH**/ ?>