<?php $__env->startSection('title', 'Категории товаров'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($breadcrumbs)): ?>
        <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <div class="element-list-wrapper category-list" data-sortable-wrapper="">
        <div class="element-container header-container">
            <?php echo $__env->make('admin.shared.resource_list.sorting._list_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="name"><?php echo e(trans('validation.attributes.name')); ?></div>
            <div class="publish-status"><?php echo e(trans('validation.attributes.publish')); ?></div>
            <div class="alias"><?php echo e(trans('validation.attributes.alias')); ?></div>
            <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
        </div>

        <div data-sortable-container="">
            <?php echo $__env->make('admin.types._type_list', ['typeTree' => $typeTree, 'lvl' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.types.update-positions'), 'reloadUrl' => empty($type) ? route('cc.types.index') : route('cc.types.show', $type->id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div>
            <a href="<?php echo e(route('cc.types.create', !empty($type) ? $type->id : null)); ?>" class="btn btn-success btn-xs">Добавить тип</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/types/index.blade.php ENDPATH**/ ?>