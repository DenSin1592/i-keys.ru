<?php if(count($homeData['manufacturersData']) > 0): ?>
    <section class="section-brands">
        <div class="container">

            <h2>Бренды из нашего каталога</h2>

            <div class="swiper-cover">
                <div class="swiper-brands js-swiper-brands swiper-container swiper-matchheight">
                    <div class="swiper-wrapper">
                        <?php $__currentLoopData = $homeData['manufacturersData']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $manufacturerData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <a href="<?php echo e($manufacturerData['url']); ?>" class="brand-card">
                                    <div class="brand-thumbnail">
                                        <img src="<?php echo e($manufacturerData['icon']); ?>" alt="<?php echo e($manufacturerData['name']); ?>">
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>

                    <div class="swiper-brands-button-prev swiper-button-prev"></div>
                    <div class="swiper-brands-button-next swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/home_page/_brands.blade.php ENDPATH**/ ?>