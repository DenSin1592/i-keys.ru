<ul class="element-list scrollable-container" data-sortable-group="">
    <?php $__currentLoopData = $manufacturerList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li data-element-id="<?php echo e($manufacturer->id); ?>">
            <div class="element-container">
                <?php echo $__env->make('admin.shared.resource_list.sorting._list_controls', ['model' => $manufacturer], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="name">
                    <a href="<?php echo e(route('cc.manufacturers.edit', [$manufacturer->id])); ?>">
                        <?php echo e($manufacturer->name); ?>

                    </a>
                </div>
                <div class="icon">
                    <a href="<?php echo e($manufacturer->getAttachment('icon')->getRelativePath()); ?>" target="_blank" data-fancybox="">
                        <img src="<?php echo e($manufacturer->getAttachment('icon')->getRelativePath('small_icon')); ?>" />
                    </a>
                </div>

                <?php echo $__env->make('admin.shared._list_flag', ['element' => $manufacturer, 'action' => route('cc.manufacturers.toggle-attribute', [$manufacturer->id, 'show_in_manufacturers_block_on_main']), 'attribute' => 'show_in_manufacturers_block_on_main'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="control">
                    <?php echo $__env->make('admin.manufacturers._list_controls', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/manufacturers/_manufacturer_list.blade.php ENDPATH**/ ?>