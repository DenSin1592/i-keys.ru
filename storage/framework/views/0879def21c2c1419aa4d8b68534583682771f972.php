<div class="element-list-wrapper category-list" data-sortable-wrapper="">
    <div class="element-container header-container">
        <?php echo $__env->make('admin.shared.resource_list.sorting._list_header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="name"><?php echo e(trans('validation.attributes.name')); ?></div>
        <div class="available-products-count"><?php echo e(trans('validation.attributes.available_products_count')); ?></div>
        <div class="total-products-count"><?php echo e(trans('validation.attributes.total_products_count')); ?></div>
        <div class="buttons"></div>
        <div class="publish-status"><?php echo e(trans('validation.attributes.publish')); ?></div>
        <div class="alias"><?php echo e(trans('validation.attributes.alias')); ?></div>
        <div class="control"><?php echo e(trans('interactions.controls')); ?></div>
    </div>

    <div data-sortable-container="">
        <?php echo $__env->make('admin.categories._category_list', ['categoryTree' => $categoryTree, 'lvl' => 0], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <?php echo $__env->make('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.categories.update-positions'), 'reloadUrl' => route('cc.categories.reload-list', empty($category) ? [] : [$category->id])], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div>
        <a href="<?php echo e(route('cc.categories.create', !empty($category) ? $category->id : null)); ?>" class="btn btn-success btn-xs">Добавить категорию</a>
        <div class="total-count"><strong>Общее число категорий</strong>: <div><?php echo e(count($categoryTree)); ?></div></div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/_category_list_wrapper.blade.php ENDPATH**/ ?>