<?php $__env->startSection('title'); ?>
    <?php echo e($category->name); ?> - список товаров
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($breadcrumbs)): ?>
        <?php echo $__env->make('admin.shared._catalog_breadcrumbs', ['breadcrumbs' => $breadcrumbs, 'category' => $category], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>

    <div class="element-list-wrapper product-list" data-sortable-wrapper="">
        <div class="element-container header-container">
            <?php echo $__env->make('admin.shared.resource_list.sorting._list_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="name"><?php echo e(trans('validation.attributes.name')); ?></div>
            <div class="publish-status"><?php echo e(trans('validation.attributes.publish')); ?></div>
            <div class="bestseller-status"><?php echo e(trans('validation.attributes.bestseller')); ?></div>
            <div class="import_disabled-status"><?php echo e(trans('validation.attributes.import_disabled')); ?></div>
            <div class="alias"><?php echo e(trans('validation.attributes.alias')); ?></div>
            <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
        </div>

        <div data-sortable-container="">
            <?php echo $__env->make('admin.products._product_list', ['productList' => $productList, 'lvl' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('admin.shared._pagination_links', ['paginator' => $productList], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="total-count"><strong>Общее число товаров</strong>: <div><?php echo e($productList->total()); ?></div></div>

        <?php echo $__env->make('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.products.update-positions'), 'reloadUrl' => route('cc.products.index', $category->id)], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.categories.inner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/index.blade.php ENDPATH**/ ?>