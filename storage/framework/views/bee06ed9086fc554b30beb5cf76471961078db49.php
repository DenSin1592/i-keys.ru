<!-- duplicate of client.categories.filter_content._banners -->
<?php if($category->rootOrSelf()->id == 1): ?>
    <!-- Матрасы -->
    <section class="section-items-category items-category-bottom d-xl-none items-content pt-0">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="d-flex">
                        <!--noindex-->
                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/matrasy/askona" style="background-image: url('/static-content/catalog/banners/matrasy/kat-mat-1.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Матрасы Аскона</span>
                            <?php endif; ?>
                        </a>
                        <!--/noindex-->
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="d-flex">
                        <!--noindex-->
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
    <section class="section-items-category items-category-bottom d-xl-none items-content pt-0">
        <div class="container p-0">
            <div class="row">
                <div class="col-12 col-sm-6">
                    <div class="d-flex">
                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/osveschenie/lustry/rasprodaja" style="background-image: url('/static-content/catalog/banners/osveschenie/kat-svet-1.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Распродажа люстр и светильников</span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>

                <div class="col-12 col-sm-6">
                    <div class="d-flex">
                        <a class="banner-aside-catalog d-flex align-items-center" href="/catalog/osveschenie/lustry/italiya" style="background-image: url('/static-content/catalog/banners/osveschenie/kat-svet-2.jpg');">
                            <?php if(false): ?>
                                <span class="aside-catalog-title">Светильники из Италии</span>
                            <?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/bottom_content/_banners.blade.php ENDPATH**/ ?>