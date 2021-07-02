<?php if(count($productData['similarBlock']['items']) > 0): ?>
    <section class="section-products">
        <div class="container">
            <div class="section-header mb-4">
                <div class="row">
                    <div class="col">
                        <div class="h2"><?php echo e($productData['similarBlock']['title']); ?></div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <div class="swiper-cover">
                        <div class="swiper-products js-swiper-products swiper-container swiper-matchheight">
                            <div class="swiper-wrapper">
                                <?php $__currentLoopData = $productData['similarBlock']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $similarProductData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="swiper-slide">
                                        <?php echo $__env->make('client.shared.products._card', ['productData' => $similarProductData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="swiper-products-button-prev swiper-button-prev d-none d-xl-block"></div>
                            <div class="swiper-products-button-next swiper-button-next d-none d-xl-block"></div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if(Auth::user()): ?>
                <div class="row">
                    <div class="col text-danger">
                        <p><?php echo nl2br($productData['similarBlock']['comment']); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_similar.blade.php ENDPATH**/ ?>