<ul class="element-list <?php if(empty($lvl) && empty($disableScrollable)): ?> scrollable-container <?php endif; ?>" data-sortable-group="">
    <?php $__currentLoopData = $typeTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li data-element-id="<?php echo e($type->id); ?>">
            <div class="element-container">
                <?php echo $__env->make('admin.shared.resource_list.sorting._list_controls', ['model' => $type], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="name">
                    <a href="<?php echo e(route('cc.types.show', [$category->id, $type->id])); ?>"
                       style="margin-left: <?php echo e($lvl * 0.5); ?>em;">
                        <?php echo e($type->name); ?>

                        <?php if($type->admin_comment != ''): ?>
                            <span title="Заполнен комментарий администратора" class="glyphicon glyphicon-tag"></span>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="available-products-count">
                    <?php echo e($type->available_products_count); ?>

                </div>
                <div class="total-products-count">
                    <?php echo e($type->total_products_count); ?>

                </div>
                <div class="buttons">
                    <?php echo $__env->make('admin.types.list._types_button', ['category' => $category, 'type' => $type], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $type, 'action' => route('cc.types.toggle-attribute', [$type->id, 'publish']), 'attribute' => 'publish'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="alias">
                    <?php echo e($type->alias); ?>

                </div>
                <div class="control">
                    <?php echo $__env->make('admin.types._control_block', ['type' => $type], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/types/_type_list.blade.php ENDPATH**/ ?>