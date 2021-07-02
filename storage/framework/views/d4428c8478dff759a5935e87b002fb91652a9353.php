<ul class="element-list scrollable-container" data-sortable-group="">
    <?php $__currentLoopData = $productList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li data-element-id="<?php echo e($product->id); ?>">
            <div class="element-container">
                <?php echo $__env->make('admin.shared.resource_list.sorting._list_controls', ['model' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="name">
                    <a href="<?php echo e(route('cc.products.edit', [$product->category->id, $product->id])); ?>"><?php echo e($product->name); ?></a>
                </div>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $product, 'action' => route('cc.products.toggle-attribute', [$product->category->id, $product->id, 'publish']), 'attribute' => 'publish'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $product, 'action' => route('cc.products.toggle-attribute', [$product->category->id, $product->id, 'bestseller']), 'attribute' => 'bestseller'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('admin.shared._list_flag', ['element' => $product, 'action' => route('cc.products.toggle-attribute', [$product->category->id, $product->id, 'import_disabled']), 'attribute' => 'import_disabled'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="alias">
                    <?php echo e($product->alias); ?>

                </div>
                <div class="control">
                    <?php echo $__env->make('admin.products._control_block', ['product' => $product], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>
        </li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</ul>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/admin/products/_product_list.blade.php ENDPATH**/ ?>