<ol class="breadcrumb">
    <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $crumbIndex => $crumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li>
            <?php if((empty($crumb['url']))): ?>
                <?php echo e($crumb['name']); ?>

            <?php else: ?>
                <a href="<?php echo e($crumb['url']); ?>"><?php echo e($crumb['name']); ?></a>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ol>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/layouts/_breadcrumbs.blade.php ENDPATH**/ ?>