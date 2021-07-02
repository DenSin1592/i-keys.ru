<ul class="element-list <?php if(empty($lvl)): ?> scrollable-container <?php endif; ?>" data-sortable-group="">
    <?php $__currentLoopData = $nodeTree; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $node): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li data-element-id="<?php echo e($node->id); ?>">
            <div class="element-container">
                <?php echo $__env->make('admin.shared.resource_list.sorting._list_controls', ['model' => $node], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="name">
                    <a href="<?php echo e(TypeContainer::getContentUrl($node)); ?>"
                       style="margin-left: <?php echo e($lvl * 0.5); ?>em;"><?php echo e($node->name); ?></a>
                </div>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $node, 'action' => route('cc.structure.toggle-attribute', [$node->id, 'publish']), 'attribute' => 'publish'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $node, 'action' => route('cc.structure.toggle-attribute', [$node->id, 'menu_top']), 'attribute' => 'menu_top'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="alias">
                    <a href="<?php echo e(TypeContainer::getClientUrl($node, true)); ?>" target="_blank">
                        <?php echo e(TypeContainer::getClientUrl($node, false)); ?>

                    </a>
                </div>
                <div class="type">
                    <?php echo e(TypeContainer::getTypeName($node->type)); ?>

                </div>
                <div class="control">
                    <?php echo $__env->make('admin.structure._node_control_block', ['node' => $node], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
            <?php if(count($node->children) > 0): ?>
                <?php echo $__env->make('admin.structure._node_list', ['nodeTree' => $node->children, 'lvl' => $lvl + 3], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/kristinayudina/works/l-keys.ru/www/resources/views/admin/structure/_node_list.blade.php ENDPATH**/ ?>