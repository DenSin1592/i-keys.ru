<fieldset class="bordered-group">
    <legend>Изображения</legend>

    <ul class="grouped-field-list product-image-list" data-element-list="container" id="image-elements">
        <?php $__empty_1 = true; $__currentLoopData = $formData['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $imageKey => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('admin.products.form.images._image', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="form-group">
                <i>Изображения не загружены</i>
            </div>
        <?php endif; ?>
    </ul>

</fieldset><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/form/images/_images.blade.php ENDPATH**/ ?>