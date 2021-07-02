<?php $__env->startSection('title', 'Создание страницы'); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::tbModelWithErrors($node, $errors, ['url' => route('cc.structure.store'), 'method' => 'post']); ?>


        <?php echo $__env->make('admin.structure._node_form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div class="action-bar">
            <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.create')); ?></button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.create_and_back_to_list')); ?></button>
            <a href="<?php echo e(route('cc.structure.index')); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
        </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.structure.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/structure/create.blade.php ENDPATH**/ ?>