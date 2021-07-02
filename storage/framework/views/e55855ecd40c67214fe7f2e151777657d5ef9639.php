<div class="col pr-0 pr-md-3 mr-1 mr-md-0">
    <div class="btn-group resort-filter-catalog">
        <div class="resort-txt d-none d-sm-inline-flex">Сортировка:</div>

        <div class="d-inline-flex d-md-none mr-3">
            <select id="resort-filter-catalog" class="select2 select2-box">
                <?php $__currentLoopData = $sortingVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($variant['url']); ?>" data-direct="<?php echo e((int)$variant['direct']); ?>"
                            <?php if($variant['active']): ?> selected="selected" <?php endif; ?>><?php echo e($variant['title']); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <div id="resort-filter-catalog-buttons" class="btn-group resort-filter-catalog d-none d-md-inline-flex flex-md-wrap">
            <?php $__currentLoopData = $sortingVariants; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button" class="btn btn-square <?php echo e($variant['active'] ? 'btn-highlight' : 'btn-transparent'); ?> mr-0"
                        data-direct="<?php echo e((int)$variant['direct']); ?>"
                        data-url="<?php echo e($variant['url']); ?>"><?php echo e($variant['title']); ?></button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="float-background"></div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_sorting.blade.php ENDPATH**/ ?>