<?php $__currentLoopData = $lensData['variants']->variants(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variantIndex => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($variant['checked']): ?>
        <button type="button" class="btn btn-square btn-bej"
                data-type="<?php echo e($lensData['type']); ?>"
                data-id="filter-<?php echo e($lensData['key']); ?>-<?php echo e($variant['value']); ?>">
            <?php echo e($variant['title_detailed']); ?>

            <?php if($lensData['units'] != ''): ?>
                <?php echo e($lensData['units']); ?>

            <?php endif; ?>
            <i class="icon-close"></i>
        </button>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/filter/current_values/_choice.blade.php ENDPATH**/ ?>