<?php
$target = $target ?? 'header';
?>
<a href="<?php echo e(route('favorites.index')); ?>" class="<?php echo e($target); ?>-action">
    <span class="<?php echo e($target); ?>-action-badge badge"><?php echo e($count); ?></span>
    <i class="<?php echo e($target); ?>-action-icon icon-favorite"></i>
    <?php echo $__env->yieldContent('label'); ?>
</a>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/_favorites_icon.blade.php ENDPATH**/ ?>