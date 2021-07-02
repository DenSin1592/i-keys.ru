<?php
$target = $target ?? 'header';
?>
<a href="<?php echo e(route('cart.show')); ?>" class="<?php echo e($target); ?>-action <?php echo e($target); ?>-action-danger">
    <span class="<?php echo e($target); ?>-action-badge badge badge-danger"><?php echo e($count); ?></span>
    <i class="<?php echo e($target); ?>-action-icon icon-cart"></i>
    <?php echo $__env->yieldContent('label'); ?>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/_cart_icon.blade.php ENDPATH**/ ?>