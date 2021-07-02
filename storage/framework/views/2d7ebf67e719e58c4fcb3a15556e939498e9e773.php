<?php if(count($productListData) > 0): ?>
    <section class="section-catalog p-0 m-0">
        <div class="catalog-grid row">
            <?php $__currentLoopData = $productListData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $productData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="catalog-item col-6 col-md-3">
                    <?php echo $__env->make('client.shared.products._card_catalog', ['productData' => $productData], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
<?php else: ?>
    <p><strong>В категории не найдено ни одного товара.</strong></p>
<?php endif; ?>

<?php if(false): ?>
    <section class="section-catalog p-0 m-0">
        <div class="catalog-grid row">
            <?php for($i = 0; $i <= 3 && $i < count($productListData); $i += 1): ?>
                <div class="catalog-item col-6 col-md-3">
                    <?php echo $__env->make('client.shared.products._card_catalog', ['productData' => $productListData[$i]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php endfor; ?>
        </div>
    </section>

    <?php if(isset($productListData[4])): ?>
        <?php if(false): ?>
        <!-- todo: вывести баннер -->
        <div class="product-feature-card product-feature-card-landscape row no-gutters">
            <a href="#link" class="product-link"></a>

            <div class="product-display-container col-md-5 col-xl-4 d-flex align-items-center justify-content-center justify-content-md-start">
                <div class="product-display">Лучшая цена</div>
            </div>

            <div class="product-container col-md-7 col-xl-8">
                <div class="row align-items-sm-center">
                    <div class="product-thumbnail-container col-auto">
                        <div class="product-thumbnail">
                            <img src="../stubs/page-home/section-products/product-item-1.png" alt="Подвесная люстра MW-Light Консуэлло 8 614012108" class="product-img">
                        </div>
                    </div>

                    <div class="product-summary-container col col-md-8">
                        <div class="row align-items-center">
                            <div class="col-xl">
                                <div class="product-title">Подвесная люстра MW-Light Консуэлло&nbsp;8 614012108</div>
                            </div>

                            <div class="col-xl-auto">
                                <div class="product-price-box d-inline-flex flex-column align-items-start flex-wrap">
                                    <div class="product-price">
                                        17&nbsp;590&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                    <div class="product-price-old">
                                        25’790&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                    <div class="product-price-sale">
                                        <div class="product-price-sale-title">Экономия</div>
                                        8200&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <section class="section-catalog p-0 m-0">
            <div class="catalog-grid row">
                <?php for($i = 4; $i <= 7 && $i < count($productListData); $i += 1): ?>
                    <div class="catalog-item col-6 col-md-3">
                        <?php echo $__env->make('client.shared.products._card_catalog', ['productData' => $productListData[$i]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endfor; ?>
            </div>
        </section>
    <?php endif; ?>

    <?php if(isset($productListData[8])): ?>
        <?php if(false): ?>
        <!-- todo: вывести баннер -->
        <div class="product-feature-card product-feature-card-landscape product-feature-card-landscape-purple row no-gutters">
            <a href="#link" class="product-link"></a>

            <div class="product-display-container col-md-5 col-xl-4 d-flex align-items-center justify-content-center justify-content-md-start">
                <div class="product-display">Товар дня</div>
            </div>

            <div class="product-container col-md-7 col-xl-8">
                <div class="row align-items-sm-center">
                    <div class="product-thumbnail-container col-auto">
                        <div class="product-thumbnail">
                            <img src="../stubs/page-home/section-products/product-item-1.png" alt="Подвесная люстра MW-Light Консуэлло 8 614012108" class="product-img">
                        </div>
                    </div>

                    <div class="product-summary-container col col-md-8">
                        <div class="row align-items-center">
                            <div class="col-xl">
                                <div class="product-title">Подвесная люстра MW-Light Консуэлло&nbsp;8 614012108</div>
                            </div>

                            <div class="col-xl-auto">
                                <div class="product-price-box d-inline-flex flex-column align-items-start flex-wrap">
                                    <div class="product-price">
                                        17&nbsp;590&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                    <div class="product-price-old">
                                        25’790&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                    <div class="product-price-sale">
                                        <div class="product-price-sale-title">Экономия</div>
                                        8200&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <section class="section-catalog p-0 m-0">
            <div class="catalog-grid row">
                <?php if(false): ?>
                <!-- todo: вывести баннер -->
                <div class="catalog-item col-6 col-md-3">
                    <div class="product-feature-card product-feature-card-portrait">
                        <a href="#link" class="product-link"></a>

                        <div class="product-display-container d-flex align-items-center">
                            <div class="product-display">Выгода <br> ДО</div>
                        </div>

                        <div class="product-container">
                            <div class="product-thumbnail-container">
                                <div class="product-thumbnail">
                                    <img src="../stubs/page-home/section-products/product-item-1.png" alt="Подвесная люстра MW-Light Консуэлло 8 614012108" class="product-img">
                                </div>
                            </div>

                            <div class="product-summary-container">
                                <div class="product-title">Подвесная люстра MW-Light Консуэлло 8 614012108</div>

                                <div class="product-price-box">
                                    <div class="product-price">
                                        17&nbsp;590&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                    <div class="product-price-old">
                                        25’790&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                    <div class="product-price-sale">
                                        <div class="product-price-sale-title">Экономия</div>
                                        8200&nbsp;<span class="rouble">руб.</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <?php for($i = 8; $i <= 15 && $i < count($productListData); $i += 1): ?>
                    <div class="catalog-item col-6 col-md-3">
                        <?php echo $__env->make('client.shared.products._card_catalog', ['productData' => $productListData[$i]], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endfor; ?>
            </div>
        </section>
    <?php endif; ?>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/_products.blade.php ENDPATH**/ ?>