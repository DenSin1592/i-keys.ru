<section class="section-products section-related-products">
    <div class="container">
        <div class="section-header">
            <div class="section-title title-h3 font-family-secondary">{{$header}}</div>

            @if(isset($subheader))
                <div class="section-alert text-danger"><span class="section-alert-media">!</span>{{$subheader}}</div>
            @endif

        </div>

        <div class="row">
            <div class="section-products-container col-lg-9 d-flex">
                <div class="swiper-products swiper-related-products swiper-container">
                    <div class="swiper-wrapper">

                        @each('client.categories._products_grid._product_card', $relatedProducts, 'productData')

                    </div>
                </div>
            </div>

            <div class="section-products-catalog-container col-lg-3 d-flex">
                <a href="{{$catalogLink}}"
                   class="card-banner card-banner-catalog d-flex flex-column justify-content-center">
                    <span class="row align-items-center justify-content-center">
                        <span class="card-banner-thumbnail-container col-auto col-lg-12">
                            <span class="card-banner-thumbnail">
                                <svg class="card-banner-media" width="40" height="40">
                                    <use xlink:href="{{$catalogImgPath}}"></use>
                                </svg>
                            </span>
                        </span>

                        <span class="card-banner-typography-container col col-sm-auto col-lg-12">
                            <span class="card-banner-title">{{$catalogText}}</span>
                        </span>
                    </span>
                </a>
            </div>
        </div>
    </div>
</section>
