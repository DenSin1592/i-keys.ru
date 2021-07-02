<?php if($category->rootOrSelf()->id == 1): ?>
    <!-- Матрасы -->
    <div class="row">
        <div class="col-12">
            <!--noindex-->
            <div class="banner-main-catalog d-flex align-items-center" role="banner">
                <picture>
                    <source media="(max-width: 320px)" srcset="/static-content/catalog/banners/matrasy/long-mat-320.jpg" >
                    <source media="(max-width: 480px)" srcset="/static-content/catalog/banners/matrasy/long-mat-480.jpg" >
                    <source media="(max-width: 750px)" srcset="/static-content/catalog/banners/matrasy/long-mat-750.jpg" >
                    <img src="/static-content/catalog/banners/matrasy/long-mat-1200.jpg" alt="Матрасы: широкий ассортимент любых видов и моделей">
                </picture>
            </div>
            <!--/noindex-->
        </div>
    </div>
<?php elseif($category->rootOrSelf()->id == 2): ?>
    <!-- Люстры -->
    <div class="row">
        <div class="col-12">
            <!--noindex-->
            <div class="banner-main-catalog d-flex align-items-center" role="banner">
                <picture>
                    <source media="(max-width: 320px)" srcset="/static-content/catalog/banners/osveschenie/long-svet-320.png" >
                    <source media="(max-width: 480px)" srcset="/static-content/catalog/banners/osveschenie/long-svet-480.png" >
                    <source media="(max-width: 750px)" srcset="/static-content/catalog/banners/osveschenie/long-svet-750.png" >
                    <img src="/static-content/catalog/banners/osveschenie/long-svet-1200.jpg" alt="Освещение: люстры, светильники, бра, торшеры">
                </picture>
            </div>
            <!--/noindex-->
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/kristinayudina/works/da-you.ru/www/resources/views/client/categories/intro_block/_banner.blade.php ENDPATH**/ ?>