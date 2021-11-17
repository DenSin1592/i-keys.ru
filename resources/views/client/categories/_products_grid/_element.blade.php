{{--<div class="item col-6 col-md-4 col-lg-3 {{ !empty($fullWidth) ? 'col-xl-3' : 'col-xl-4' }} {{ $gridElementClass ?? '' }}">
    <div class="product-card vertical">
        <div class="product-media">
            <a href="{{ UrlBuilder::getUrl($productData['product']) }}" class="product-thumbnail">
                @if(isset($productData['image']))
                    <img src="{{ $productData['image']->getAttachment('image')->getUrl('middle') }}" alt="{{ $productData['product']->name }}" class="product-img">
                @else
                    @include('client.shared._no_image', ['image_class' => 'product-img'])
                @endif
            </a>
        </div>
        <div class="product-body">
            <a href="{{ UrlBuilder::getUrl($productData['product']) }}" class="product-title">
                {!! \Arr::get($productData, 'productTypePageAdditionalInfo.name', $productData['product']->highlighted_name) !!}
            </a>
            @include('client.categories._product._compare_btn', ['product' => $productData['product'], 'hasShortText' => true])
        </div>

        @if($productData['product']->available)
            <div class="product-footer">
                <div class="product-price">
                    {!! Helper::priceFormat($productData['product']->price) !!}
                </div>
                @include('client.categories._product._add_to_cart', ['product' => $productData['product']])
            </div>
        @endif
    </div>
</div>--}}


<div class="product-item col-sm-6 col-md-4 col-lg-3 col-xl-4 d-flex">
    <div class="card-product card-product-portrait">
        <div class="card-product-badges d-flex">
            <div class="card-product-badge">
                <svg class="card-product-badge-media" width="39" height="45">
                    <use xlink:href="/images/client/sprite.svg#icon-coding"></use>
                </svg>
            </div>

            <div class="card-product-badge">
                <svg class="card-product-badge-media" width="45" height="45">
                    <use xlink:href="/images/client/sprite.svg#icon-no-keys"></use>
                </svg>
            </div>
        </div>

        <div class="card-product-thumbnail">
            <img loading="lazy" src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-product-media">
        </div>

        <a href="#link" class="card-product-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

        <div class="card-product-info-list">
            <div class="card-product-size-block card-product-info-block d-flex">
                <label for="card-product-size-1" class="card-product-info-title card-product-size-title">Типоразмер</label>

                <select name="" id="card-product-size-1" class="card-product-size custom-control custom-select" style="width: auto;" >
                    <option value="50*60мм">50*60мм</option>
                    <option value="60*70мм">60*70мм</option>
                </select>
            </div>

            <div class="card-product-color-block card-product-info-block d-flex">
                <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                <div class="card-product-color-list d-flex flex-wrap">
                    <div class="card-product-color custom-control custom-color custom-color-sm">
                        <input type="radio" class="custom-control-input" id="card-product-color-1-1" name="card-product-color-1" checked >
                        <label for="card-product-color-1-1" class="custom-control-label">
                            <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                        </label>
                    </div>

                    <div class="card-product-color custom-control custom-color custom-color-sm">
                        <input type="radio" class="custom-control-input" id="card-product-color-1-2" name="card-product-color-1" >
                        <label for="card-product-color-1-2" class="custom-control-label">
                            <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                        </label>
                    </div>

                    <div class="card-product-color custom-control custom-color custom-color-sm">
                        <input type="radio" class="custom-control-input" id="card-product-color-1-3" name="card-product-color-1" >
                        <label for="card-product-color-1-3" class="custom-control-label">
                            <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-product-order-block mt-auto">
            <div class="form-row flex-nowrap">
                <div class="card-product-price-container col">
                    <div class="card-product-price-block d-flex flex-wrap">
                        <div class="card-product-price">187<span class="rouble" ></span></div>
                    </div>
                </div>

                <div class="card-product-cart-container col-auto">
                    <button type="button" class="card-product-cart d-flex align-items-center justify-content-center" >
                        <svg class="card-product-cart-media d-none d-lg-inline" width="16" height="14">
                            <use xlink:href="/images/sprite.svg#icon-cart"></use>
                        </svg>
                        Купить
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
