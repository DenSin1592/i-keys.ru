<ul class="element-list <?php if(empty($lvl)): ?> scrollable-container <?php endif; ?>" data-sortable-group="">
    <?php $__currentLoopData = $categoryTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li data-element-id="<?php echo e($category->id); ?>">
            <div class="element-container">
                <?php echo $__env->make('admin.resource_list_sortable._list_sorting_controls', ['model' => $category], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="name">
                    <a href="<?php echo e(route('cc.categories.show', $category->id)); ?>"
                       style="margin-left: <?php echo e($lvl * 0.5); ?>em;"><?php echo e($category->name); ?></a>
                </div>
                <div class="buttons">
                    <a href="<?php echo e(route('cc.categories.show', [$category->id])); ?>" class="btn btn-default btn-xs">Подкатегории</a>
                    <a href="<?php echo e(route('cc.products.index', [$category->id])); ?>" class="btn btn-default btn-xs">Товары</a>
                    <a href="<?php echo e(route('cc.attributes.index', [$category->id])); ?>" class="btn btn-default btn-xs">Параметры</a>
                </div>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $category, 'action' => route('cc.categories.toggle-attribute', [$category->id, 'publish']), 'attribute' => 'publish'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="alias">
                    <?php echo e($category->alias); ?>

                </div>
                <div class="control">
                    <?php echo $__env->make('admin.categories._control_block', ['category' => $category], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/categories/_category_list.blade.php ENDPATH**/ ?>