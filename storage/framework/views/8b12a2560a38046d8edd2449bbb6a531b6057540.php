<?php $__currentLoopData = $filterVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lensData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="product-filter-lens">
        <span class="lens-title"><?php echo e($lensData['name']); ?></span>
        <div>
            <?php echo $__env->make("admin.types.filter.lens._{$lensData['type']}", ['lensData' => $lensData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>
    </div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/filter/_filter.blade.php ENDPATH**/ ?>