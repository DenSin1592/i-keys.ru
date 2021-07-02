<?php $__env->startSection('title'); ?>
    <?php echo e('Структура сайта'); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="node-list element-list-wrapper" data-sortable-wrapper="">
        <div class="element-container header-container">
            <?php echo $__env->make('admin.shared.resource_list.sorting._list_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="name"><?php echo e(trans('validation.attributes.name')); ?></div>
            <div class="publish-status"><?php echo e(trans('validation.attributes.publish')); ?></div>
            <div class="menu_top-status"><?php echo e(trans('validation.attributes.menu_top')); ?></div>
            <div class="alias"><?php echo e(trans('validation.attributes.alias')); ?></div>
            <div class="type"><?php echo e(trans('validation.attributes.type')); ?></div>
            <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
        </div>

        <div data-sortable-container="">
            <?php echo $__env->make('admin.structure._node_list', ['nodeTree' => $nodeTree, 'lvl' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.structure.update-positions'), 'reloadUrl' => route('cc.structure.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div>
            <a href="<?php echo e(route('cc.structure.create')); ?>" class="btn btn-success btn-xs">Добавить страницу</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/structure/index.blade.php ENDPATH**/ ?>