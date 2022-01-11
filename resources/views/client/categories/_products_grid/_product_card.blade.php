 <div class="card-product card-product-portrait" data-card-number="{{$cardNumber}}">

        <div class="card-product-thumbnail">
            <img loading="lazy" src="{{$productData['product']->getFirstImagePath('image', 'catalog', 'no-image-200x200.png')}}" alt="{{$productData['product']->name}}" class="card-product-media">
        </div>

        <a href="{{\UrlBuilder::getUrl($productData['product'])}}" class="card-product-title">{!! $productData['productTypePageAdditionalInfo']['name'] ?? $productData['product']->name !!}</a>

        <div class="card-product-info-list">

            @if(isset($productData['sizes_cylinder']))
                <div class="card-product-size-block card-product-info-block d-flex align-items-center">
                    <label for="card-product-size-{{$cardNumber}}" class="card-product-info-title card-product-size-title">Типоразмер</label>

                    <select name="" id="card-product-size-{{$cardNumber}}" class="card-product-size custom-control custom-select change-card custom-select-inline" style="width: auto;">
                        @foreach($productData['sizes_cylinder'] as $element)
                            <option value="{{$element['product_id']}}" @if($element['isActive']) selected @endif>{{$element['attr_value']}}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="card-product-color-block card-product-info-block d-flex align-items-center">

                @if(isset($productData['colors']))
                    <label for="" class="card-product-info-title card-product-color-title">Цвет</label>

                    <div class="card-product-color-list d-flex flex-wrap">

                        @foreach($productData['colors'] as $key => $element)

                            <div class="card-product-color custom-control custom-color custom-color-sm">
                                <input type="radio" class="custom-control-input change-card" id="card-product-color-{{$cardNumber}}-{{$key}}" value="{{$element['product_id']}}" name="card-product-color-{{$cardNumber}}" @if($element['isActive'])checked @endif>
                                <label for="card-product-color-{{$cardNumber}}-{{$key}}" class="custom-control-label">
                                    <img loading="lazy" src="{{$element['imgPath']}}" alt="{{$element['attr_value']}}" class="custom-control-image">
                                </label>
                            </div>

                        @endforeach

                    </div>
                @endif
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
                            @include('client.shared.catalog.product.button._in_cart')
                        @else
                            @include('client.shared.catalog.product.button._add_to_card', ['product' => $productData['product']])
                        @endif
                    @endif

                </div>
            </div>
        </div>
    </div>
