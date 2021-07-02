

<?php if(isset($model->created_at)): ?>
    <?php echo Form::tbFormGroupOpen(); ?>

        <label><?php echo e(trans('validation.attributes.created_at')); ?></label><br/>
        <?php echo e($model->created_at->format('H:i:s d.m.Y')); ?>

    <?php echo Form::tbFormGroupClose(); ?>

<?php endif; ?>

<?php if(isset($model->updated_at)): ?>
    <?php echo Form::tbFormGroupOpen(); ?>

        <label><?php echo e(trans('validation.attributes.updated_at')); ?></label><br/>
        <?php echo e($model->updated_at->format('H:i:s d.m.Y')); ?>

    <?php echo Form::tbFormGroupClose(); ?>

<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/shared/_model_timestamps.blade.php ENDPATH**/ ?>