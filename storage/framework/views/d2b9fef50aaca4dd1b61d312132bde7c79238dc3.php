<div class="form-group form-group-range <?php echo e($lensData['for_admin_filter'] && !Auth::check() ? 'd-none' : ''); ?>">
    <div class="h5 filter-aside-title <?php echo e($lensData['for_admin_filter'] ? 'text-danger' : ''); ?>"><?php echo e($lensData['name']); ?></div>

    <div class="range-block">
        <div class="slider-range" data-decimals="0" data-from="#filter-<?php echo e($lensData['key']); ?>-from" data-to="#filter-<?php echo e($lensData['key']); ?>-to"></div>
    </div>

    <div class="filter-range">
        <div class="range-header d-flex justify-content-between no-gutters">
            <div class="col-label-range d-flex align-items-center mt-2">
                <input id="filter-<?php echo e($lensData['key']); ?>-from" class="cost" type="number" step="any" name="filter[<?php echo e($lensData['key']); ?>][from]" data-border="<?php echo e($lensData['variants']->variants()['min']); ?>" value="<?php echo e($lensData['variants']->variants()['from']); ?>">
            </div>

            <div class="col-space-range d-flex justify-content-center">
                <label for="filter-<?php echo e($lensData['key']); ?>-to">&mdash;</label>
            </div>

            <div class="col-label-range d-flex mt-2">
                <input id="filter-<?php echo e($lensData['key']); ?>-to" class="cost" type="number" step="any" name="filter[<?php echo e($lensData['key']); ?>][to]" data-border="<?php echo e($lensData['variants']->variants()['max']); ?>" value="<?php echo e($lensData['variants']->variants()['to']); ?>">
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/filter/form/controls/_range.blade.php ENDPATH**/ ?>