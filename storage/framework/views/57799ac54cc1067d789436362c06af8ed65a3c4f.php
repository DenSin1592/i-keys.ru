<?php $__env->startSection('title', 'Создание типа товаров'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::tbModelWithErrors($formData['type'], $errors, ['url' => route('cc.types.store', [$formData['type']->id]), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']); ?>


    <?php echo $__env->make('admin.types._form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::hidden('position', $formData['type']->position); ?>


    <div class="action-bar">
        <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.save')); ?></button>
        <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.save_and_back_to_list')); ?></button>

        <a href="<?php echo e(route('cc.types.index')); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
        <?php if($formData['type']->in_tree_publish): ?>
        <!-- todo: site url -->
        <?php endif; ?>
    </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.categories.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/types/create.blade.php ENDPATH**/ ?>