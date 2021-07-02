<div class="product-gallery-images">
    <?php echo $__env->make('client.products.show._images._actions', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="swiper-container">
        <div class="swiper-wrapper">
            <?php $__currentLoopData = $productData['productImages']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productImage): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <a class="product-gallery-image-link"
                       href="<?php echo e($productImage->getAttachment('image')->exists() ? $productImage->getAttachment('image')->getUrl() : url('images/common/no-image/no-image-800x800.png')); ?>"
                       data-fancybox="gallery-photo"
                       data-caption="<?php echo e($productData['product']->name); ?>"><?php if($productImage->getAttachment('image')->exists()): ?><img src="<?php echo e($productImage->getAttachment('image')->getUrl('main')); ?>" alt="<?php echo e($productData['product']->name); ?>" title="<?php echo e($productData['product']->name); ?>" /><?php else: ?><img src="<?php echo e(url('images/common/no-image/no-image-500x500.png')); ?>" alt="<?php echo e($productData['product']->name); ?>" title="<?php echo e($productData['product']->name); ?>" /><?php endif; ?></a>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="swiper-pagination swiper-bullet swiper-bullet-product d-md-none"></div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_images/_gallery.blade.php ENDPATH**/ ?>