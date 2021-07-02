<footer class="footer-box">
    <?php echo $__env->make('client.layouts.footer._catalog_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="footer-bottom">
        <div class="container">
            <div class="footer-content">
                <div class="row">
                    <div class="col-md-3 col-xl-3">
                        <div class="row">
                            <div class="col-sm-4 col-md-12">
                                <!--noindex-->
                                <a href="<?php echo e(route('home')); ?>" class="logo-box footer-logo-box d-flex">
                                    <div class="logo-title"><?php echo e(Setting::get('general.site_name')); ?></div>
                                </a>
                                <!--/noindex-->
                            </div>

                            <div class="col-sm-8 col-md-12">
                                <!--noindex-->
                                <div class="footer-copyright-box">
                                    &copy;&nbsp;<?php echo e(\Carbon\Carbon::now()->format('Y')); ?> <?php echo e(Str::ucfirst(Setting::get('general.site_name'))); ?> — Маркетплейс необходимых товаров для дома
                                </div>
                                <!--/noindex-->
                            </div>
                        </div>
                        
                        <div class="privacy d-none d-xl-flex">
                            <?php echo $__env->make('client.shared._privacy._link', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>

                        <div class="col-auto map-box ml-auto d-none d-xl-flex">
                            <!--noindex-->
                            <a class="icon-map" href="<?php echo e(route('map')); ?>"></a>
                            <!--/noindex-->
                        </div>
                    </div>
                    

                    <div class="col-md col-xl-7">
                        <div class="search-box footer-search-box">
                            <?php echo $__env->make('client.layouts._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                        <?php echo $__env->make('client.layouts.footer._includes._desktop_nav_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php echo $__env->make('client.layouts.footer._includes._mobile_nav_menu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    </div>

                    <div class="col-auto col-xl-2 ml-auto">
                        <div class="counter-box d-none d-lg-block">
                            <?php echo $__env->make('client.layouts.counters._liveinternet', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/_footer.blade.php ENDPATH**/ ?>