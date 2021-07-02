<?php if($filterVariants->hasActive()): ?>
    <div class="col pr-0 pr-xl-3 mr-1 mr-xl-0">
        <div class="btn-group btn-group-filter" id='filter-reset'>
            <?php $__currentLoopData = $filterVariants->variants(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lensData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make("client.shared.filter.current_values._{$lensData['type']}", ['lensData' => $lensData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <button type="button" class="btn btn-square btn-red" data-reset-filter="1" data-url="<?php echo e(CatalogUrlBuilder::buildCategoryUrl($category)); ?>"><i class="icon-close"></i> Очистить все</button>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/filter/_current_values.blade.php ENDPATH**/ ?>