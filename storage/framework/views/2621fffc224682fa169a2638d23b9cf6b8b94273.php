<div class="header-main d-none d-md-block">
    <div class="container">
        <div class="header-content">
            <div class="row align-items-center">
                <div class="col-auto">
                    <div class="header-catalog-box">
                        <a href="javascript:void(0);" class="header-catalog-toggle" >
                            <i class="icon-catalog" ></i>
                            <span class="d-xl-none" >Товары</span>
                            <span class="d-none d-xl-inline-block" >Каталог товаров</span>
                        </a>

                        <?php echo $__env->make('client.layouts.header.header_main._menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>

                <?php echo $__env->make('client.layouts.header.header_main._search', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <div class="col-auto">
                    <!--noindex-->
                    <div class="header-actions-box d-flex">
                        <div id='header-main-favorites-icon' class="header-action-item">
                            <?php echo $__env->make('client.layouts._favorites_icon_main', ['count' => $favoritesCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        <div id='header-main-compare-icon' class="header-action-item">
                            <?php echo $__env->make('client.layouts._compare_icon_main', ['count' => $compareCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        <div id='header-main-cart-icon' class="header-action-item">
                            <?php echo $__env->make('client.layouts._cart_icon_main', ['count' => $cartCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                    <!--/noindex-->
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/header/_header_main.blade.php ENDPATH**/ ?>