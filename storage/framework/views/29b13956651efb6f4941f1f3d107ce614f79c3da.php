<div class="form-group <?php echo e($lensData['for_admin_filter'] && !Auth::check() ? 'd-none' : ''); ?>">
    <div class="h5 filter-aside-title <?php echo e($lensData['for_admin_filter'] ? 'text-danger' : ''); ?>"><?php echo e($lensData['name']); ?></div>

    <ul class="filter-block">
        <?php $__currentLoopData = $lensData['variants']->variants(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variantIndex => $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li class="filter-variant <?php echo e($variantIndex >= 10 ? 'collapsible' : ''); ?> <?php echo e(isset($filterExpandedParams[$lensData['key']]) ? 'visible' : ''); ?> <?php echo e($variant['for_admin_filter'] && !Auth::check() ? 'd-none' : ''); ?> <?php echo e($variant['for_admin_filter'] ? 'text-danger' : ''); ?> <?php echo e(!$variant['available'] ? 'disabled' : ''); ?>">
                <input id="filter-<?php echo e($lensData['key']); ?>-<?php echo e($variant['value']); ?>"
                       name="filter[<?php echo e($lensData['key']); ?>][]" value="<?php echo e($variant['value']); ?>"
                       type="checkbox"
                       <?php if($variant['checked']): ?> checked="checked" <?php endif; ?>
                       <?php if(!$variant['available']): ?> disabled="disabled" <?php endif; ?>>
                <label for="filter-<?php echo e($lensData['key']); ?>-<?php echo e($variant['value']); ?>"><?php echo e($variant['title']); ?></label>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>

    <?php if(count($lensData['variants']->variants()) > 10): ?>
        <a class="section-link filter-more <?php echo e(isset($filterExpandedParams[$lensData['key']]) ? 'active' : ''); ?>"
           href="javascript:void(0);" data-id="<?php echo e($lensData['key']); ?>">
            <i class="icon-menu"></i>
            <span data-text-default="Показать все" data-text-active="Свернуть"><?php echo e(isset($filterExpandedParams[$lensData['key']]) ? 'Свернуть' : 'Показать все'); ?></span>
        </a>
    <?php endif; ?>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/filter/form/controls/_choice.blade.php ENDPATH**/ ?>