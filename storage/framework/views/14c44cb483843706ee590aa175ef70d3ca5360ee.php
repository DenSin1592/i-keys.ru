<?php $__env->startSection('title'); ?>
    Производители
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="element-list-wrapper manufacturer-list" data-sortable-wrapper="">
        <div class="element-container header-container">
            <?php echo $__env->make('admin.shared.resource_list.sorting._list_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="name"><?php echo e(trans('validation.attributes.name')); ?></div>
            <div class="icon"><?php echo e(trans('validation.attributes.icon_file')); ?></div>
            <div class="show_in_manufacturers_block_on_main-status"><?php echo e(trans('validation.attributes.show_in_manufacturers_block_on_main')); ?></div>
            <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
        </div>

        <div data-sortable-container="">
            <?php echo $__env->make('admin.manufacturers._manufacturer_list', ['manufacturerList' => $manufacturerList], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('admin.shared._pagination_links', ['paginator' => $manufacturerList], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="total-count"><strong>Общее число производителей</strong>: <div><?php echo e($manufacturerList->total()); ?></div></div>

        <?php echo $__env->make('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.manufacturers.update-positions'), 'reloadUrl' => route('cc.manufacturers.index')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div>
            <a href="<?php echo e(route('cc.manufacturers.create')); ?>" class="btn btn-success btn-xs">Добавить производителя</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/manufacturers/index.blade.php ENDPATH**/ ?>