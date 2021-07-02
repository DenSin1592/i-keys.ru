<a href="<?php echo e(CatalogUrlBuilder::buildProductUrl($productData['product'])); ?>" class="product-link" <?php if(false): ?>data-toggle="modal" data-target="#modalCard"<?php endif; ?>></a>
<!-- todo: сделать модальное окно со всплывающими товарами -->

<div class="product-labels-box">
    <?php if(false): ?>
    <!-- todo: вывести новинки -->
        <div class="product-label label label-danger">Новинка</div>
    <?php endif; ?>
    <?php if($productData['product']->discount_percent > 0): ?>
        <div class="product-label label label-warning">- <?php echo e($productData['product']->discount_percent); ?>%</div>
    <?php endif; ?>
</div>

<div class="product-thumbnail-container">
    <div class="product-thumbnail">
        <?php if(!is_null($productData['image']) && $productData['image']->getAttachment('image')->exists('list')): ?>
            <img src="<?php echo e($productData['image']->getAttachment('image')->getUrl('list')); ?>" alt="<?php echo e($productData['customName'] ?? $productData['product']->name); ?>" title="<?php echo e($productData['customName'] ?? $productData['product']->out_name); ?>" class="product-img">
        <?php else: ?>
            <img src="/images/common/no-image/no-image-200x200.png" alt="<?php echo e($productData['customName'] ?? $productData['product']->out_name); ?>" title="<?php echo e($productData['customName'] ?? $productData['product']->out_name); ?>" class="product-img">
        <?php endif; ?>
    </div>
</div>

<div class="product-summary-container">
    <div class="product-title">
        <a href="<?php echo e(CatalogUrlBuilder::buildProductUrl($productData['product'])); ?>"><?php echo $productData['customName'] ?? $productData['product']->highlighted_out_name; ?></a>
    </div>

<?php if(false): ?>
    <!-- todo: вывести отзывы в списке -->
        <div class="product-rating-box rating-box d-flex">
            <div class="rating">
                <i class="icon-star" ></i>
                <i class="icon-star" ></i>
                <i class="icon-star" ></i>
                <i class="icon-star" ></i>
                <i class="icon-star is-disabled" ></i>
            </div>

            <div class="rating-label">152 отзыва</div>
        </div>
    <?php endif; ?>

    <?php echo $__env->make('client.categories._show_rating', $productData, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php echo $__env->make('client.categories._attributes', $productData, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="product-price-box">
        <?php if($productData['product']->price > 0): ?>
            <div class="product-price">
                <?php echo Number::formatPrice($productData['product']->price, '.', '&nbsp;'); ?>&nbsp;<span class="rouble">руб.</span>
            </div>
        <?php endif; ?>
        <?php if($productData['product']->old_price > $productData['product']->price): ?>
            <div class="product-price-old">
                <?php echo Number::formatPrice($productData['product']->old_price, '.', '’'); ?>&nbsp;<span class="rouble">руб.</span>
            </div>
            <div class="product-price-sale">
                <span class="sale">-</span><?php echo e(Number::formatPrice($productData['product']->old_price - $productData['product']->price, '.', ' ')); ?>&nbsp;<span class="rouble">руб.</span>
            </div>
        <?php endif; ?>
    </div>

    <?php if($productData['product']->price > 0): ?>
        <div class="product-actions d-flex align-items-center">
            <a href="javascript:void(0);" class="product-cart-toggle" data-product-id="<?php echo e($productData['product']->id); ?>">
                <i class="icon-cart d-none d-sm-inline-block d-md-none d-lg-inline-block" ></i>
                В корзину
            </a>
            <!-- todo: добавить is-active, когда товар в корзине и написать текст "В корзине" -->

            <div class="ml-auto d-flex">
                <?php echo $__env->make('client.shared.products._favorites_button', ['product' => $productData['product']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('client.shared.products._compare_button', ['product' => $productData['product']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/shared/products/_card_content.blade.php ENDPATH**/ ?>