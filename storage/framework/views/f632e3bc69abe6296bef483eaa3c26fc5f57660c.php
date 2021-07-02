

<?php echo Form::tbFormGroupOpen('parent_id'); ?>

    <?php echo Form::tbLabel('parent_id', trans('validation.attributes.parent_id')); ?>

    <?php echo Form::tbSelect2('parent_id', $parentVariants); ?>

<?php echo Form::tbFormGroupClose(); ?>



<?php echo Form::tbFormGroupOpen('type'); ?>

    <?php echo Form::tbLabel('type', trans('validation.attributes.type')); ?>

    <select id="type" name="type" class="form-control" data-node-type>
        <?php $__currentLoopData = TypeContainer::getEnabledTypeList($node->id); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeKey => $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($typeKey); ?>" data-unique="<?php echo e($type->getUnique()); ?>" <?php echo old('type', $node->type) == $typeKey ? 'selected="selected"' : ''; ?>><?php echo $type->getName(); ?></option>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('name'); ?>

    <?php echo Form::tbLabel('name', trans('validation.attributes.name')); ?>

    <?php echo Form::tbText('name'); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbFormGroupOpen('alias'); ?>

    <?php echo Form::tbLabel('alias', trans('validation.attributes.alias')); ?>

    <?php echo Form::tbText('alias'); ?>

<?php echo Form::tbFormGroupClose(); ?>


<?php echo Form::tbCheckboxBlock('publish'); ?>

<?php echo Form::tbCheckboxBlock('menu_top'); ?>


<?php echo $__env->make('admin.shared._model_timestamps', ['model' => $node], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/structure/_node_form_fields.blade.php ENDPATH**/ ?>