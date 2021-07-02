<div class="product-rating-box catalog-rating-box rating-box d-flex align-items-center">
    <div class="rating">
        <?php for($i = 1; $i <= 5; $i++): ?>
            <?php if($i <= $productData['rating']['star']): ?>
                <i class="icon-star"></i>
            <?php else: ?>
                <i class="icon-star is-disabled"></i>
            <?php endif; ?>
        <?php endfor; ?>
    </div>

    <?php if($productData['rating']['count_reviews'] > 0): ?>
    <div class="rating-counts">
        <?php echo e($productData['rating']['count_reviews']); ?> <?php echo e(trans_choice('отзыв|отзыва|отзывов', $productData['rating']['count_reviews'])); ?>

    </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_show_rating.blade.php ENDPATH**/ ?>