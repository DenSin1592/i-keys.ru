<?php $__env->startSection('title'); ?>
    <?php echo e($formData['category']->name); ?> - редактирование
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::tbModelWithErrors($formData['category'], $errors, ['url' => route('cc.categories.update', [$formData['category']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']); ?>


        <?php echo $__env->make('admin.categories._form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo Form::hidden('position', $formData['category']->position); ?>


        <div class="action-bar">
            <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.save')); ?></button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.save_and_back_to_list')); ?></button>
            <?php echo $__env->make('admin.categories._delete_category', ['category' => $formData['category']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php if($formData['parent']): ?>
                <a href="<?php echo e(route('cc.categories.show', $formData['parent']->id)); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
            <?php else: ?>
                <a href="<?php echo e(route('cc.categories.index')); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
            <?php endif; ?>
            <?php if($formData['category']->in_tree_publish): ?>
                <!-- todo: site url -->
            <?php endif; ?>
        </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.categories.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/categories/edit.blade.php ENDPATH**/ ?>