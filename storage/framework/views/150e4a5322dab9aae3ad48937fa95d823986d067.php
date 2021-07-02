<div class="element-list-wrapper type-list" data-sortable-wrapper="">
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
        <?php echo $__env->make('admin.types._type_list', ['typeTree' => $typeTree, 'lvl' => 0, 'category' => $category], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>

    <?php echo $__env->make('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.types.update-positions'), 'reloadUrl' =>  route('cc.types.reload-list', [$category->id, object_get($type, 'id')])], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div>
        <a href="<?php echo e(route('cc.types.create', [$category->id, object_get($type, 'id')])); ?>" class="btn btn-success btn-xs">Добавить тип</a>
        <div class="total-count"><strong>Общее число типов</strong>: <div><?php echo e(count($typeTree)); ?></div></div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/_type_list_wrapper.blade.php ENDPATH**/ ?>