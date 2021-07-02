<?php $__env->startSection('title', 'Создание категории'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::tbModelWithErrors($formData['category'], $errors, ['url' => route('cc.categories.store'), 'method' => 'post', 'files' => true]); ?>


        <?php echo $__env->make('admin.categories._form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="action-bar">
            <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.create')); ?></button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.create_and_back_to_list')); ?></button>

            <?php if($formData['parent']): ?>
                <a href="<?php echo e(route('cc.categories.show', $formData['parent']->id)); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
            <?php else: ?>
                <a href="<?php echo e(route('cc.categories.index')); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
            <?php endif; ?>
        </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.categories.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/categories/create.blade.php ENDPATH**/ ?>