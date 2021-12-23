<section class="section-products">
    <div class="container">
        <div class="section-header">
            <div class="section-title title-h3 font-family-secondary">Сопутствующие товары</div>
        </div>

        <ul class="products-nav-tabs nav nav-tabs d-flex flex-nowrap" role="tablist">
            @foreach($relatedProducts as $key => $v)

                <li class="nav-item" role="presentation">
                    <a class="nav-link @if($loop->iteration === 1) active @endif" id="products-tab-{{$loop->iteration}}"
                       data-toggle="tab" href="#products-pane-{{$loop->iteration}}" role="tab"
                       aria-controls="products-pane-{{$loop->iteration}}" aria-selected="true">{{__('categories.' . $key)}}</a>
                </li>

            @endforeach
        </ul>

        <div class="products-tab-content tab-content">
            @foreach($relatedProducts as $productsData)
                <div class="tab-pane fade @if($loop->iteration === 1) show active @endif"
                     id="products-pane-{{$loop->iteration}}" role="tabpanel"
                     aria-labelledby="products-tab-{{$loop->iteration}}">
                    <div class="swiper-products swiper-container">
                        <div class="swiper-wrapper">

                            @foreach($productsData as $key => $productData)
                                @include('client.categories._products_grid._product_card', [
                                    'productData' => $productData,
                                    'cardClass' => 'swiper-slide col-auto col-sm-6 col-md-4 col-lg-3 d-flex',
                                    'cardNumber' => $key,
                                ])
                            @endforeach

                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
