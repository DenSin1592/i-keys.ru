<div class="product-item col-sm-6 col-md-4 col-lg-3 col-xl-4 d-flex">
    <div class="card-product card-product-portrait">
        <div class="card-product-badges d-flex">
{{--            <div class="card-product-badge">--}}
{{--                <svg class="card-product-badge-media" width="39" height="45">--}}
{{--                    <use xlink:href="/images/client/sprite.svg#icon-coding"></use>--}}
{{--                </svg>--}}
{{--            </div>--}}

{{--            <div class="card-product-badge">--}}
{{--                <svg class="card-product-badge-media" width="45" height="45">--}}
{{--                    <use xlink:href="/images/client/sprite.svg#icon-no-keys"></use>--}}
{{--                </svg>--}}
{{--            </div>--}}
        </div>

        <div class="card-product-thumbnail">
            <img loading="lazy" src="{{$productData['product']->getFirstImagePath('image', 'catalog', 'no-image-200x200.png')}}" alt="{{$productData['product']->name}}" class="card-product-media">
        </div>

        <a href="{{\UrlBuilder::getUrl($productData['product'])}}" class="card-product-title">{{$productData['product']->name}}</a>

        <div class="card-product-info-list">
{{--            <div class="card-product-size-block card-product-info-block d-flex">--}}
{{--                <label for="card-product-size-{{$loop->iteration}}" class="card-product-info-title card-product-size-title">Типоразмер</label>--}}

{{--                <select name="" id="card-product-size-{{$loop->iteration}}" class="card-product-size custom-control custom-select" style="width: auto;" >--}}
{{--                    <option value="50*60мм">50*60мм</option>--}}
{{--                    <option value="60*70мм">60*70мм</option>--}}
{{--                </select>--}}
{{--            </div>--}}

            <div class="card-product-color-block card-product-info-block d-flex">
{{--                <label for="" class="card-product-info-title card-product-color-title">Цвет</label>--}}

{{--                <div class="card-product-color-list d-flex flex-wrap">--}}

{{--                    <div class="card-product-color custom-control custom-color custom-color-sm">--}}
{{--                        <input type="radio" class="custom-control-input" id="card-product-color-{{$loop->iteration}}-1" name="card-product-color-1" checked >--}}
{{--                        <label for="card-product-color-1-1" class="custom-control-label">--}}
{{--                            <img loading="lazy" src="/uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">--}}
{{--                        </label>--}}
{{--                    </div>--}}

{{--                </div>--}}
            </div>
        </div>

        <div class="card-product-order-block mt-auto">
            <div class="form-row flex-nowrap">
                <div class="card-product-price-container col">
                    <div class="card-product-price-block d-flex flex-wrap">
                        <div class="card-product-price"> {!! Helper::priceFormat($productData['product']->price) !!}<span class="rouble" ></span></div>
                        <div class="card-product-old-price"> {!! Helper::priceFormat($productData['product']->getOldPrice()) !!}<span class="rouble"></span></div>
                    </div>
                    <div class="card-product-sale-price text-danger">{{$productData['product']->sale_string}}</div>
                </div>

                <div class="card-product-cart-container col-auto">

                    @if ($productData['product']->price > 0.0)
                        @if(\App\Facades\Cart::checkItem($productData['product']->id))
                            @include('client.shared.product.button._in_cart')
                        @else
                            @include('client.shared.product.button._add_to_card', ['product' => $productData['product']])
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
