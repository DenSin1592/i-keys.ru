<?php if($lensData['variants']->hasActive()): ?>
    <button type="button" class="btn btn-square btn-bej"
            data-type="<?php echo e($lensData['type']); ?>"
            data-id-from="filter-<?php echo e($lensData['key']); ?>-from"
            data-id-to="filter-<?php echo e($lensData['key']); ?>-to">
        <?php echo e($lensData['variants']->variants()['from']); ?> — <?php echo e($lensData['variants']->variants()['to']); ?>

        <?php if($lensData['units'] != ''): ?>
            <?php echo e($lensData['units']); ?>

        <?php endif; ?>
        <i class="icon-close"></i>
    </button>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/filter/current_values/_range.blade.php ENDPATH**/ ?>