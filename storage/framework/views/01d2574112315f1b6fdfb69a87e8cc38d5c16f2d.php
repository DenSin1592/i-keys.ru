

<?php echo Form::tbFormGroupOpen('parent_key'); ?>

    <?php echo Form::tbLabel('parent_key', trans('validation.attributes.parent_key')); ?>

    <?php echo Form::tbSelect2('parent_key', $formData['parentVariants'], $formData['parentKey']); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbTextBlock('name'); ?>


<?php echo Form::tbTextBlock('alias'); ?>


<?php echo Form::tbCheckboxBlock('publish'); ?>


<?php echo Form::tbTextareaBlock('admin_comment', null, null, ['hint' => 'Не отображается на сайте']); ?>


<?php echo $__env->make('admin.shared._header_meta_field', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo Form::tbTinymceTextareaBlock('top_content'); ?>


<?php echo Form::tbTinymceTextareaBlock('bottom_content'); ?>


<?php echo $__env->make('admin.types.filter._filter_block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.types.product_name_templates._templates', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.types.products._products_block', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.shared._form_meta_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php echo $__env->make('admin.shared._model_timestamps', ['model' => $formData['type']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/_form_fields.blade.php ENDPATH**/ ?>