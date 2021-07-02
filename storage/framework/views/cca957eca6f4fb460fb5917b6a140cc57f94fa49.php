<?php $__env->startSection('content'); ?>
<div class="page-product">

    <div class="container">
        <div class="row">
            <div class="col">
                <?php echo $__env->make('client.shared.breadcrumbs._breadcrumbs', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>

    <section class="section-product">
        <div class="container">
            <div class="row flex-column d-md-block">
                <div class="product-media-container col-12 col-md-6 float-md-left col-xl-7">
                    <?php echo $__env->make('client.products.show._images', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="product-header-container col-12 col-md-6 offset-md-6 col-xl-5 offset-xl-7">
                    <div class="product-header d-flex align-items-start">


                        <div class="product-header-typogrpahy-container" >
                            <div class="product-heading">
                                <h1><?php echo e($h1); ?></h1>
                            </div>

                            <div class="product-header-info-container">
                                <div class="form-row align-items-center">
                                    <div class="col-12 col-sm-auto">
                                        <?php if(in_array($productData['product']->category_id, [\App\Models\Category::POSTELNOE, \App\Models\Category::NAVOLOCHKI, \App\Models\Category::KOMPLEKTYE, \App\Models\Category::PROSTYNIE,  \App\Models\Category::PODODEYANIKI])): ?>
                                            <?php if($productData['product']->new_article): ?>
                                                <div class="product-code">Артикул <span
                                                        class="code"><?php echo e($productData['product']->new_article); ?></span></div>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <?php if($productData['product']->article): ?>
                                                <div class="product-code">Артикул <span
                                                        class="code"><?php echo e($productData['product']->article); ?></span></div>
                                            <?php endif; ?>
                                        <?php endif; ?>
                                    </div>

                                    <div class="col-12 col-sm-auto">
                                        <?php echo $__env->make('client.products.show._show_rating', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php if($productData['price'] > 0): ?>
                    <div class="product-aside-content col-12 col-md-6 offset-md-6 col-xl-5 offset-xl-7">
                        <div class="row">
                            <div class="col">

                                <?php echo $__env->make('client.products.show._buttons', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


                                <?php if(!empty($productData['product'])): ?>
                                    <div class="product-partner">
                                        <img class="mr-2" src="/images/client/icons/svg/icon-handshake.svg">
                                        <?php if($productData['product']->shop_id == 1): ?>
                                            Партнер: "Гипермаркет матрасов"
                                        <?php elseif($productData['product']->shop_id == 2): ?>
                                            Партнер: "МАГСВЕТ"
                                        <?php elseif($productData['product']->shop_id == 3): ?>
                                            Партнер: "Моя постель"
                                        <?php endif; ?>
                                    </div>

                                    <?php if($productData['product']->id % 2 === 0): ?>
                                        <div class="product-stats">
                                            <img class="mr-2" src="/images/client/icons/svg/icon-people.svg" alt="Уже заказали товар">
                                            <?php echo e(trans_choice('messages.person_ordered', $productData['ordersCount'])); ?> этот товар
                                        </div>
                                    <?php endif; ?>
                                <?php endif; ?>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="section-product-specifications">
        <div class="container">
            <div class="row">
                <div class="product-specifications-container col-12 col-xl-6">
                    <?php echo $__env->make('client.products.show._characteristics', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>

                <div class="product-info-container col-12 col-xl-5 offset-xl-1">
                    <div class="form-row">
                        <div class="col-sm-6 col-lg-4 col-xl-12 d-flex">
                            <!--noindex-->
                            <div class="product-info-block">
                                <div class="product-info-title h5">ДОСТАВКА</div>

                                <ul class="product-info-includes reset-list">
                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-legend.png" alt="График доставки" class="product-info-media"> -->
                                            <i class="icon-legend"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            График доставок заказов с 9:00 до 20:00.
                                        </div>
                                    </li>

                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-moscow.png" alt="Доставка по Москве" class="product-info-media"> -->
                                            <i class="icon-moscow"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            <a href="<?php echo e(url($productData['delivery']['link'])); ?>" target="_blank">Доставка</a> по Москве и области — от 590&nbsp;рублей, доставим <?php echo e($productData['delivery']['date']->isoFormat('Do MMMM')); ?> <br>
                                            <b>БЕСПЛАТНО</b> доставим при заказе от 5000&nbsp;рублей.
                                        </div>
                                    </li>

                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-russia.png" alt="Доставка по России" class="product-info-media"> -->
                                            <i class="icon-russia"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            Доставка по России — от 590&nbsp;рублей, доставим <?php echo e($productData['delivery']['date']->isoFormat('Do MMMM')); ?> <br>
                                            <b>БЕСПЛАТНО</b> доставим при заказе от 10000&nbsp;рублей.
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--/noindex-->
                        </div>

                        <div class="col-sm-6 col-lg-4 col-xl-12 d-flex">
                            <!--noindex-->
                            <div class="product-info-block">
                                <div class="product-info-title h5">ОПЛАТА</div>

                                <ul class="product-info-includes reset-list">
                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-cards.png" alt="Оплата картой" class="product-info-media"> -->
                                            <i class="icon-cards"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            Картой, <a href="<?php echo e(url($productData['payment']['link'])); ?>" target="_blank" >оплата</a> производится  онлайн и при получении картой любого банка:
                                            <img src="/images/client/pages/page-product/card-icons.png" alt="Оплата картой любого банка">
                                        </div>
                                    </li>

                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-coins.png" alt="Оплата наличными" class="product-info-media"> -->
                                            <i class="icon-coins"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            Наличными, оплата производится при получении.
                                        </div>
                                    </li>

                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-receipt.png" alt="Безналичный расчет" class="product-info-media"> -->
                                            <i class="icon-receipt"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            Безналичный расчет, оплата производится <br> путем выставления счета.
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--/noindex-->
                        </div>

                        <div class="col-sm-6 col-lg-4 col-xl-12 d-flex">
                            <!--noindex-->
                            <div class="product-info-block">
                                <div class="product-info-title h5">ГАРАНТИЯ И ВОЗВРАТ</div>

                                <ul class="product-info-includes reset-list">
                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-guard.png" alt="Гарантия" class="product-info-media"> -->
                                            <i class="icon-guard"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            <a href="<?php echo e(url($productData['warranty']['link'])); ?>" target="_blank">Гарантия</a>
                                            <?php if(!is_null($productData['warranty']['value'])): ?>
                                                на покупку <?php echo e($productData['warranty']['value']); ?>

                                            <?php else: ?>
                                                от производителя
                                            <?php endif; ?>
                                        </div>
                                    </li>

                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-take-back.png" alt="Возврат" class="product-info-media"> -->
                                            <i class="icon-take-back"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            До 30 дней на возврат товара.
                                        </div>
                                    </li>

                                    <li class="product-info-include d-flex d-sm-block d-md-flex">
                                        <div class="product-info-thumbnail d-flex align-items-center justify-content-center">
                                            <!-- <img src="/images/client/icons/png/icon-certificate.png" alt="Сертификат качества" class="product-info-media"> -->
                                            <i class="icon-certificate"></i>
                                        </div>

                                        <div class="product-info-content align-self-center">
                                            Только сертифицированная и оригинальная продукция.
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!--/noindex-->
                        </div>
                    </div>
                </div>











            </div>
        </div>
    </section>




    <?php echo $__env->make('client.products.show._reviews', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



    <?php echo $__env->make('client.products.show._similar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('client.layouts.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/products/show.blade.php ENDPATH**/ ?>