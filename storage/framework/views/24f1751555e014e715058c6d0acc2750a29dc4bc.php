<?php $__env->startSection('title'); ?>
    <?php echo e($formData['type']->name); ?> - редактирование
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::tbModelWithErrors($formData['type'], $errors, ['url' => route('cc.types.update', [$formData['category']->id, $formData['type']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']); ?>


    <?php echo $__env->make('admin.types._form_fields', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo Form::hidden('position', $formData['type']->position); ?>


    <div class="action-bar">
        <button type="submit" class="btn btn-success"><?php echo e(trans('interactions.save')); ?></button>
        <button type="submit" class="btn btn-primary" name="redirect_to" value="index"><?php echo e(trans('interactions.save_and_back_to_list')); ?></button>
        <?php echo $__env->make('admin.types._delete_type', ['category' => $formData['category'], 'type' => $formData['type']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <a href="<?php echo e(route('cc.categories.show', $formData['category']->id)); ?>" class="btn btn-default"><?php echo e(trans('interactions.back_to_list')); ?></a>
        <?php if($formData['type']->in_tree_publish && $formData['type']->category->in_tree_publish): ?>
            <?php echo $__env->make('admin.shared._show_on_site_button', ['url' => CatalogUrlBuilder::buildTypeUrl($formData['type'])], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>

    <?php echo Form::close(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.categories.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/edit.blade.php ENDPATH**/ ?>