<?php if(isset($homeData['homeProducts'][\App\Models\HomePageProduct::GROUP_NOVELS]) && count($homeData['homeProducts'][\App\Models\HomePageProduct::GROUP_NOVELS]) >= 5): ?>
    <section class="section-products section-arrivals section-dark">
        <div class="container">
            <div class="section-header">
                <div class="row">
                    <div class="col">
                        <div class="h2 section-title">Новинки</div>
                    </div>
                    <div class="col-auto">
                        <a href="<?php echo e(route('novels')); ?>" class="section-link">
                            <i class="icon-menu"></i>
                            <span>Смотреть все</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="swiper-cover">
                <div class="swiper-products js-swiper-products swiper-container swiper-matchheight">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $homeData['homeProducts'][\App\Models\HomePageProduct::GROUP_NOVELS]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $novelData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <?php echo $__env->make('client.shared.products._card', ['productData' => $novelData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="swiper-products-button-prev swiper-button-prev d-none d-xl-block"></div>
                    <div class="swiper-products-button-next swiper-button-next d-none d-xl-block"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/home_page/products/_novels.blade.php ENDPATH**/ ?>