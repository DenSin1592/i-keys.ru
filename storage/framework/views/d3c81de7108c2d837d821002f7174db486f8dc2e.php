<div class="header-top d-none d-md-block">
    <div class="container">
        <div class="header-content">
            <div class="row flex-nowrap align-items-center">
                <div class="col-auto d-xl-none">
                    <a href="javascript:void(0);" class="offcanvas-toggle" >
                        <i class="icon-menu" ></i>
                    </a>
                </div>

                <div class="col-auto">
                    <a href="<?php echo e(route('home')); ?>" class="logo-box header-logo-box d-flex">
                        <div class="logo-title">
                            <?php echo e(Setting::get('general.site_name')); ?>

                        </div>

                        <?php if(false): ?>
                            <!-- slogan was removed according to seo-task -->
                            <div class="logo-slogan d-none d-xxl-block">
                                Маркетплейс <br> всего-всего-всего
                            </div>
                        <?php endif; ?>
                    </a>
                </div>

                <?php echo $__env->make('client.layouts.header.header_top._city', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('client.layouts.header.header_top._top_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('client.layouts.header.header_top._phone', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php echo $__env->make('client.layouts.header.header_top._user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <!-- <div class="col-auto d-md-none">
                    <div class="header-actions-box d-flex">
                        <div id='header-top-search-icon' class="header-action-item">
                            <a href="javascript:void(0);" class="header-action">
                                <i class="header-action-icon icon-search"></i>
                            </a>
                        </div>

                        <div class="header-action-item d-none d-sm-block">
                            <a href="javascript:void(0);" class="header-action">
                                <i class="header-action-icon icon-user"></i>
                            </a>
                        </div>

                        <div id='header-top-cart-icon' class="header-action-item">
                            <?php echo $__env->make('client.layouts._cart_icon_top', ['count' => $cartCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/header/_header_top.blade.php ENDPATH**/ ?>