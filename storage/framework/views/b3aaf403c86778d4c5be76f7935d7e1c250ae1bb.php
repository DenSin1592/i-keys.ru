<form class="filter-aside-catalog p-0 p-lg-3" action="<?php echo e(route('filter.url')); ?>" method="get" autocomplete="off">
    <?php if($filterVariants->hasActive()): ?>
        <button type="button" class="btn btn-square btn-red btn-reset-filter"
                data-reset-filter="1" data-url="<?php echo e(CatalogUrlBuilder::buildCategoryUrl($category)); ?>"><i class="icon-close"></i> Очистить все</button>
    <?php endif; ?>

    <?php $__currentLoopData = array_slice($filterVariants->variants(), 0, 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lensData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php echo $__env->make("client.shared.filter.form.controls._{$lensData['type']}", ['lensData' => $lensData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <?php if(count($filterVariants->variants()) > 5): ?>
        <div id="filter-expand" class="collapse <?php echo e($filterExpanded ? 'show' : ''); ?>">
            <?php $__currentLoopData = array_slice($filterVariants->variants(), 5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lensData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php echo $__env->make("client.shared.filter.form.controls._{$lensData['type']}", ['lensData' => $lensData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <button class="btn btn-info btn-block filter-expand <?php echo e(!$filterExpanded ? 'collapsed' : ''); ?>" type="submit"
                data-toggle="collapse" data-target="#filter-expand" aria-expanded="false" aria-controls="more-filter">
            <span data-text-default="Показать остальные" data-text-active="Свернуть"><?php echo e($filterExpanded ? 'Свернуть' : 'Показать остальные'); ?></span>
        </button>
    <?php endif; ?>

    <input type="hidden" name="category" value="<?php echo e($category->id); ?>" />
    <input type="hidden" name="sorting" value="<?php echo e($sorting); ?>" />
</form>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/filter/form/_form.blade.php ENDPATH**/ ?>