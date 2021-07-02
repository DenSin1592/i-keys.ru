<div class="product-order">
    <div class="row flex-xl-nowrap no-gutters">
        <div class="col-auto d-flex flex-column align-items-start">
            <div class="product-price">
                <?php echo e(Number::formatPrice($productData['price'], ',')); ?>&nbsp;<span class="rouble">руб.</span>
            </div>

            <?php if($productData['old_price'] > $productData['price']): ?>
                <div class="product-price-old">
                    <?php echo e(Number::formatPrice($productData['old_price'], ',', '’')); ?>&nbsp;<span class="rouble">руб.</span>
                </div>
            <?php endif; ?>

            <div class="mt-1">
                <span>В наличии</span>
            </div>
        </div>

        <?php if($productData['old_price'] > $productData['price']): ?>
            <div class="col-auto d-flex justify-content-md-center align-items-start ml-3">
                <div class="product-price-sale">
                    <div class="product-price-sale-title">Вы экономите</div>
                    <?php echo e(Number::formatPrice($productData['old_price'] - $productData['price'], ',', ' ')); ?>&nbsp;<span class="rouble">руб.</span>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-12 col-sm col-md-12 col-xl">
            <div class="product-actions d-flex flex-sm-column flex-md-row flex-xl-column align-items-start float-sm-right float-md-none">
                <?php echo $__env->make('client.products.show._buttons._to_favorites', ['product' => $productData['product']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('client.products.show._buttons._to_compare', ['product' => $productData['product']], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <div class="form-row justify-content-md-between">
        <?php echo $__env->make('client.products.show._buttons._add_to_cart', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>

    <div class="product-order-contacts form-row justify-content-md-between">



    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show/_buttons.blade.php ENDPATH**/ ?>