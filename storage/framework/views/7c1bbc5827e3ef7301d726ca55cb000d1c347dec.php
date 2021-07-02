<div class="header-fixed is-fixed">
	<div class="container">
		<div class="header-content">
			<div class="row flex-nowrap align-items-center">
				<div class="col-auto d-xl-none">
	                <a href="javascript:void(0);" class="offcanvas-toggle">
	                    <i class="icon-menu"></i>
	                </a>
	            </div>

				<div class="col-auto d-none d-xl-block">
					<div class="header-catalog-box">
	                    <a href="javascript:void(0);" class="header-catalog-toggle" >
	                        <i class="icon-catalog" ></i>
	                        <span class="d-xl-none" >Товары</span>
	                        <span class="d-none d-xl-inline-block" >Каталог товаров</span>
	                    </a>
	                </div>
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

				<div class="col d-none d-xl-block">
				    <div class="search-box header-search-box">
				        <?php echo $__env->make('client.layouts._search_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
				    </div>
				</div>


				<div class="col-auto mx-auto mx-xl-0">
					<div class="header-contact-box">
				        <a href="tel:<?php echo e($sitePhone['short']); ?>" class="header-contact" >
				            <i class="icon-phone d-none d-md-inline-block" ></i>
				            <?php echo e($sitePhone['full']); ?>

				        </a>

				        <a href="javascript:void(0);"
                           class="header-contact-action btn-outline btn-sm d-none d-md-inline-block"
                           data-toggle="modal"
                           data-target="#modalCallback"
                        >
                            Перезвоните мне
                        </a>

				    </div>
				</div>

				<div class="col-auto">
					<!--noindex-->
					<div class="header-actions-box d-flex">
						<div id='header-top-search-icon' class="header-action-item d-xl-none">
	                        <a href="javascript:void(0);" class="header-action">
	                            <i class="header-action-icon icon-search"></i>
	                        </a>
	                    </div>

	                    <div class="header-action-item d-none d-sm-block d-md-none">
	                        <a href="javascript:void(0);" class="header-action">
	                            <i class="header-action-icon icon-user"></i>
	                        </a>
	                    </div>

	                    <div id='header-top-favorites-icon' class="header-action-item d-none d-md-block">
	                        <?php echo $__env->make('client.layouts._favorites_icon_main', ['count' => $favoritesCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	                    </div>

	                    <div id='header-top-compare-icon' class="header-action-item d-none d-md-block">
	                        <?php echo $__env->make('client.layouts._compare_icon_main', ['count' => $compareCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	                    </div>

	                    <div id='header-top-cart-icon' class="header-action-item">
	                        <?php echo $__env->make('client.layouts._cart_icon_top', ['count' => $cartCount], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
	                    </div>
	                </div>
					<!--/noindex-->
				</div>
			</div>
		</div>
	</div>
</div>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/layouts/header/_header_fixed.blade.php ENDPATH**/ ?>