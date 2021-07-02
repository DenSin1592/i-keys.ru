<?php $__env->startSection('title'); ?>
<?php echo e($node->name); ?> - редактирование
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::tbModelWithErrors($node, $errors, ['url' => route('cc.structure.update', [$node->id]), 'method' => 'put']); ?>


        <?php echo $__env->make('admin.structure._node_form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <?php echo Form::hidden('position', $node->position); ?>


        <div class="action-bar">
            <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.save')); ?></button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.save_and_back_to_list')); ?></button>
            <?php echo $__env->make('admin.structure._delete_node', ['node' => $node], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <a href="<?php echo e(TypeContainer::getContentUrl($node)); ?>" class="btn btn-default"><?php echo e(trans('interactions.edit')); ?></a>
            <a href="<?php echo e(route('cc.structure.index')); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
            <?php if($node->in_tree_publish): ?>
                <?php echo $__env->make('admin.shared._show_on_site_button', ['url' => TypeContainer::getClientUrl($node)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php if($node->in_tree_publish): ?>
    <?php $__env->startSection('go_to_site_link'); ?>
        <?php echo $__env->make('admin.shared._go_to_site_button', ['url' => TypeContainer::getClientUrl($node)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php $__env->stopSection(); ?>
<?php endif; ?>

<?php echo $__env->make('admin.structure.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru_2021/www/resources/views/admin/structure/edit.blade.php ENDPATH**/ ?>