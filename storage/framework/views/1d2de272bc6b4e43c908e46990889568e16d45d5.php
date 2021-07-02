<!-- duplicate of client.categories.bottom_content._banners -->
<?php if($category->rootOrSelf()->id == 1): ?>
    <!-- Матрасы -->
    <section class="section-items-category items-content d-none d-lg-block pb-0 mt-0">
        <div class="container p-0">
            <div class="row">
                <div class="col">
                    <div class="d-flex flex-column">
                        <!--noindex-->
                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/matrasy/askona" style="background-image: url('/static-content/catalog/banners/matrasy/kat-mat-1.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Матрасы Аскона</span>
                            <?php endif; ?>
                        </a>

                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/matrasy/bespruzhinnye" style="background-image: url('/static-content/catalog/banners/matrasy/kat-mat-2.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Беспружинные матрасы</span>
                            <?php endif; ?>
                        </a>
                        <!--/noindex-->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php elseif($category->rootOrSelf()->id == 2): ?>
    <!-- Люстры -->
    <section class="section-items-category items-content d-none d-lg-block pb-0 mt-0">
        <div class="container p-0">
            <div class="row">
                <div class="col">
                    <div class="d-flex flex-column">
                        <!--noindex-->
                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/osveschenie/lustry/rasprodaja" style="background-image: url('/static-content/catalog/banners/osveschenie/kat-svet-1.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Распродажа люстр и светильников</span>
                            <?php endif; ?>
                        </a>

                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/osveschenie/lustry/italiya" style="background-image: url('/static-content/catalog/banners/osveschenie/kat-svet-2.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Светильники из Италии</span>
                            <?php endif; ?>
                        </a>
                        <!--/noindex-->
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/filter_block/_banners.blade.php ENDPATH**/ ?>