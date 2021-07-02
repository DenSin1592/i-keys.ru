<?php $__currentLoopData = $formData['attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo Form::tbFormGroupOpen("attributes.{$attribute['attribute']->id}"); ?>

        <?php echo Form::tbLabel("attributes[{$attribute['attribute']->id}]", $attribute['attribute']->name); ?>

        <?php echo $__env->make("admin.products.form.attributes._attribute_{$attribute['attribute']->attribute_type}", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo Form::tbFormGroupClose(); ?>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/attributes/_attributes.blade.php ENDPATH**/ ?>