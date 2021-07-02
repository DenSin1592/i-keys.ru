<?php
$options = [];
if (!empty($disabled)) {
    $options['disabled'] = true;
}
?>
<div>
    <div class="multi-checkbox">
        <div class="variants-container">
            <?php $__currentLoopData = array_chunk($attribute['allowedValues'], 4, true); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="multi-checkbox-row">
                    <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $allowedId => $allowedName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="multi-checkbox-element">
                            <label class="checkbox-inline">
                                <?php echo Form::checkbox("attributes[{$attribute['attribute']->id}][]", $allowedId, in_array($allowedId, $attribute['data']), $options); ?>

                                <?php echo e($allowedName); ?>

                            </label>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/attributes/_attribute_multiple.blade.php ENDPATH**/ ?>