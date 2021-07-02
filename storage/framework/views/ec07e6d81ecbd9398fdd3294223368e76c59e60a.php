

<?php echo Form::tbFormGroupOpen('parent_id'); ?>

    <?php echo Form::tbLabel('parent_id', trans('validation.attributes.parent_id')); ?>

    <?php echo Form::tbSelect2('parent_id', $formData['parentVariants']); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('catalog_type'); ?>

    <?php echo Form::tbLabel('catalog_type', trans('validation.attributes.catalog_type')); ?>

    <?php echo Form::tbSelect2('catalog_type', $formData['catalogTypeVariants']); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbTextBlock('name'); ?>


<?php echo Form::tbTextBlock('alias'); ?>


<?php echo Form::tbCheckboxBlock('publish'); ?>


<?php echo $__env->make('admin.shared._header_meta_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo Form::tbTinymceTextareaBlock('top_content'); ?>


<?php echo Form::tbTinymceTextareaBlock('content'); ?>


<?php echo Form::tbTinymceTextareaBlock('bottom_content'); ?>


<?php echo $__env->make('admin.shared._form_meta_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.shared._model_timestamps', ['model' => $formData['category']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/categories/_form_fields.blade.php ENDPATH**/ ?>