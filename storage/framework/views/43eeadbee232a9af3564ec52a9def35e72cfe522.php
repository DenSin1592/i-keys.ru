<div class="choice-lens">
    <?php $__currentLoopData = $lensData['variants']->variants(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variant): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <label class="checkbox-inline">
            <?php echo Form::checkbox("filter[{$lensData['key']}][]", $variant['value'], $variant['checked']); ?>

            <?php echo e($variant['title']); ?>

        </label>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/filter/lens/_choice.blade.php ENDPATH**/ ?>