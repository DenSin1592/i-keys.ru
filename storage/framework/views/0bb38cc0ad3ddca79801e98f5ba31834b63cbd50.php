<?php $__env->startSection('title', 'Категории товаров'); ?>

<?php $__env->startSection('content'); ?>
    <?php if(isset($breadcrumbs)): ?>
        <?php echo $__env->make('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    <div class="element-list-wrapper category-list" data-sortable-wrapper="">
        <div class="element-container header-container">
            <?php echo $__env->make('admin.resource_list_sortable._list_sorting_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <div class="name"><?php echo e(trans('validation.attributes.name')); ?></div>
            <div class="buttons"></div>
            <div class="publish-status"><?php echo e(trans('validation.attributes.publish')); ?></div>
            <div class="alias"><?php echo e(trans('validation.attributes.alias')); ?></div>
            <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
        </div>

        <div data-sortable-container="">
            <?php echo $__env->make('admin.categories._category_list', ['categoryTree' => $categoryTree, 'lvl' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        </div>

        <?php echo $__env->make('admin.resource_list_sortable._sorting_controls', ['updateUrl' => route('cc.categories.update-positions'), 'reloadUrl' => route('cc.categories.show')], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        <div>
            <a href="<?php echo e(route('cc.categories.create', !empty($category) ? $category->id : null)); ?>" class="btn btn-success btn-xs">Добавить категорию</a>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/index.blade.php ENDPATH**/ ?>