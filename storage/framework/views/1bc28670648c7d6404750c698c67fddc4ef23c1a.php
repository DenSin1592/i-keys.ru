

<?php echo Form::tbFormGroupOpen('parent_id'); ?>

    <?php echo Form::tbLabel('parent_id', trans('validation.attributes.parent_id')); ?>

    <?php echo Form::tbSelect2('parent_id', $formData['parentVariants']); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('category_id'); ?>

    <?php echo Form::tbLabel('category_id', trans('validation.attributes.category_id')); ?>

    <?php echo Form::tbSelect2('category_id', $formData['categoryVariants']); ?>

<?php echo Form::tbFormGroupClose(); ?>



<?php echo Form::tbTextBlock('name'); ?>


<?php echo Form::tbTextBlock('alias'); ?>


<?php echo Form::tbCheckboxBlock('publish'); ?>


<?php echo $__env->make('admin.shared._header_meta_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo Form::tbTinymceTextareaBlock('top_content'); ?>


<?php echo Form::tbTinymceTextareaBlock('content'); ?>


<?php echo Form::tbTinymceTextareaBlock('bottom_content'); ?>


<?php echo $__env->make('admin.shared._form_meta_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.shared._model_timestamps', ['model' => $formData['type']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/types/_form_fields.blade.php ENDPATH**/ ?>