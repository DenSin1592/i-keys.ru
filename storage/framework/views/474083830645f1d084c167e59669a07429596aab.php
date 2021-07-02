<?php $__env->startSection('title', 'Страница не найдена'); ?>

<?php $__env->startSection('content'); ?>
    Запрашиваемая вами страница не существует или была удалена.<br/>
    Вы можете вернуться на <?php echo e(link_to_route('cc.home', 'главную страницу')); ?>.
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/errors/404/admin.blade.php ENDPATH**/ ?>