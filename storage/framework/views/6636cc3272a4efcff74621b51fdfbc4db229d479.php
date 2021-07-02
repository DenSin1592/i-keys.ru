<div id="offcanvas">
    <div class="offcanvas-bar">
        <div class="row align-items-center">
            <div class="col-auto">
                <a href="javascript:void(0);" class="offcanvas-close">
                    <i class="icon-close" ></i>
                </a>
            </div>

            <?php if(false): ?>
            <div class="col-auto">
                <div class="offcanvas-location-box location-box">
                    <a href="javascript:void(0);" class="offcanvas-location-toggle location-toggle" data-toggle="modal" data-target="#modalCity" >
                        <i class="icon-location"></i>
                        Санкт-Петербург
                    </a>
                </div>
            </div>
            <?php endif; ?>

            <?php if(false): ?>
            <div class="col-auto ml-auto">
                <div class="offcanvas-private-office-box private-office-box d-flex">
                    <div class="private-office-item">
                        <a href="javascript:void(0);" class="private-office-link" data-toggle="modal" data-target="#modalLogin">
                            <i class="icon-user"></i>
                            Вход
                        </a>
                        <div id='header-cart-icon-with-label' class="header-action-item">
                            <?php echo $__env->make('client.layouts._cart_icon_with_label', ['count' => $cartCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="offcanvas-header">
        <div class="row">
            <div class="col">
                <div class="offcanvas-search-box search-box">
                    <?php echo $__env->make('client.layouts._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            </div>

            <div class="col-auto">
                <div class="offcanvas-actions-box d-flex">
                    <div id="header-offcanvas-favorites-icon" class="offcanvas-action-item">
                        <?php echo $__env->make('client.layouts._favorites_icon_offcanvas', ['count' => $favoritesCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>


                    <div id="header-offcanvas-compare-icon" class="offcanvas-action-item">
                        <?php echo $__env->make('client.layouts._compare_icon_offcanvas', ['count' => $compareCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>

                    <div id="header-offcanvas-cart-icon" class="offcanvas-action-item">
                        <?php echo $__env->make('client.layouts._cart_icon_offcanvas', ['count' => $cartCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="offcanvas-main">
        <div class="offcanvas-contact-box">
            <a href="tel:<?php echo e($sitePhone['short']); ?>" class="offcanvas-contact">
                <i class="icon-phone"></i>
                <?php echo e($sitePhone['full']); ?>

            </a>

            <a href="javascript:void(0);" class="offcanvas-contact-action btn-outline btn-sm" data-toggle="modal" data-target="#modalCallback">Перезвоните мне</a>
        </div>

        <div class="offcanvas-megamenu-wrapper js-offcanvas-megamenu-wrapper"></div>

        <?php if(count($topMenu)): ?>
            <ul class="offcanvas-links reset-list">
                <?php $__currentLoopData = $topMenu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuElement): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="offcanvas-link-item <?php echo e($menuElement['active'] ? 'active' : ''); ?>">
                        <a href="<?php echo e($menuElement['url']); ?>" class="offcanvas-link"><?php echo e($menuElement['name']); ?></a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/_offcanvas.blade.php ENDPATH**/ ?>