<?php if(isset($productData['show_in_list_attributes'])): ?>
    <ul class="product-specifications-list list-unstyled">
    <?php $__currentLoopData = $productData['show_in_list_attributes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attribute): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        <?php if(!isset($attribute['name'])): ?>
            <?php continue; ?>
        <?php endif; ?>

        <?php if(count($attribute['values']) > 1): ?>
            <li class="product-specification-item form-row flex-nowrap justify-content-between">
                <span class="product-specification-label col"><?php echo e($attribute['name']); ?>:</span>
                <span class="product-specification-value col text-right">
                    <?php $__currentLoopData = $attribute['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($key !== array_key_last($attribute['values'])): ?>
                            <?php echo e($value); ?>,
                        <?php else: ?>
                            <?php echo e($value); ?>

                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </span>
            </li>
        <?php elseif(count($attribute['values']) === 1): ?>
            
            <?php $__currentLoopData = $attribute['values']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="product-specification-item form-row flex-nowrap justify-content-between">
                    <span class="product-specification-label col"><?php echo e($attribute['name']); ?>:</span>
                    <span class="product-specification-value col text-right"><?php echo e($value); ?></span>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_attributes.blade.php ENDPATH**/ ?>