<h2 class="product-specification-title" >Характеристики</h2>

<div class="row">
    <?php $__currentLoopData = collect($productData['characteristics'])->chunk(ceil(collect($productData['characteristics'])->count() / 2)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chunk): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-12 col-sm-6">
            <ul class="product-specifications-list reset-list">
                <?php $__currentLoopData = $chunk; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $valueIndex => $valueNote): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="product-specification-item d-flex justify-content-between align-items-center">
                        <div class="product-specification-label"><?php echo e($valueNote['attribute']->name); ?></div>
                        <div class="product-specification-value product-specification-value-fluid"><?php echo e($valueNote['value']); ?></div>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_characteristics.blade.php ENDPATH**/ ?>