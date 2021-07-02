<section class="section-reviews">
    <div class="container">

        <div class="section-header">
            <div class="row">
                <div class="col">
                    <h2>Отзывы</h2>
                </div>
            </div>
        </div>

        <?php if(count($productData['productReviews']) > 0): ?>
            <div class="section-reviews-grid">
                <div class="row">

                    <?php ($i = 0); ?>

                    <?php $__currentLoopData = $productData['productReviews']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <?php ($i++); ?>

                        <div class="review-item <?php if($i > 3): ?> review-item-secondary <?php endif; ?> col-12 col-xl-4">
                            <div class="review-card">
                                <div class="review-header d-flex">
                                    <div class="review-media">
                                        <img src="/images/client/icons/svg/user-noimage.svg">
                                    </div>

                                    <div class="review-info">
                                        <div class="review-name"><?php echo e($review->name); ?></div>
                                        <div class="review-time"><?php echo e($review->review_date_formatted); ?></div>
                                    </div>
                                </div>

                                <div class="review-description">
                                    <?php echo e($review->content); ?>

                                </div>

                                <?php if(!empty($review->content_answer)): ?>
                                    <div class="response-card">
                                        <div class="response-header">
                                            <div class="response-title">Ответ от магазина</div>
                                            <div class="response-time"></div>
                                        </div>

                                        <div class="response-description"><?php echo e($review->content_answer); ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>

            <?php if(count($productData['productReviews']) > 3): ?>
                <div class="review-load-btn-group">
                    <button class="load-reviews-button btn btn-block btn-highlight" data-show-reviews="full">
                        Показать еще <?php echo e(count($productData['productReviews'])-3); ?>

                    </button>

                    <button class="load-reviews-button btn btn-block btn-highlight d-none" data-show-reviews="short">
                        Свернуть
                    </button>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div>Станьте первым, кто оставит отзыв о товаре <?php echo e($product->name); ?></div>
        <?php endif; ?>

        <a class="btn leave-review-button" href="javascript:void(0);" data-toggle="modal" data-target="#modalReview">Оставить отзыв</a>

    </div>
</section>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_reviews.blade.php ENDPATH**/ ?>