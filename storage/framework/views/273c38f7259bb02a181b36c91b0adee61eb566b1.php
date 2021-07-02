<?php if(count($productData['productImages']) > 0): ?>
    <div class="product-gallery-wrapper">
        <?php echo $__env->make('client.products.show._images._gallery', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php if(count($productData['productImages']) > 1): ?>
            <?php echo $__env->make('client.products.show._images._thumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_images.blade.php ENDPATH**/ ?>