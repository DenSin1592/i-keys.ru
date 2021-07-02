<?php if($paginator instanceof Illuminate\Pagination\LengthAwarePaginator): ?>
    <div class="pagination-container">
        <label class="pagination-limit">
            Элементов на странице:
            <select class="choose-on-page form-control" id="switch-pagination-limit">
                <?php $__currentLoopData = resolve('flex-paginator.available_limits'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $limit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option <?php echo e($paginator->perPage() == $limit ? 'selected="selected"' : ''); ?> value="<?php echo e($paginator->path() . '?' . Arr::query([$paginator->getPageName() => 1, 'limit' => $limit])); ?>"><?php echo e($limit); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </label>
        <?php echo $paginator->links(); ?>

    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/shared/_pagination_links.blade.php ENDPATH**/ ?>