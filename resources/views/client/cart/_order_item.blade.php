<div class="order-item" data-cart-product-id="{{$item['product']->id}}">
    <div class="card-order">
        <div class="card-order-inner">
            <div class="row align-items-lg-center">

                <div class="card-order-thumbnail-container col-3 col-sm-2 col-lg-auto">
                    <div class="card-order-badges-block d-flex">
                        {{--                                            <div class="card-order-badge">--}}
                        {{--                                                <svg class="card-order-badge-media" width="39" height="45">--}}
                        {{--                                                    <use xlink:href="/images/client/sprite.svg#icon-coding"></use>--}}
                        {{--                                                </svg>--}}
                        {{--                                            </div>--}}

                        {{--                                            <div class="card-order-badge">--}}
                        {{--                                                <svg class="card-order-badge-media" width="45" height="45">--}}
                        {{--                                                    <use xlink:href="/images/client/sprite.svg#icon-no-keys"></use>--}}
                        {{--                                                </svg>--}}
                        {{--                                            </div>--}}
                    </div>

                    <a href="{{\UrlBuilder::getUrl($item['product'])}}" class="card-order-thumbnail d-flex align-items-center justify-content-center">
                        <img src="{{$item['product']->getFirstImagePath('image', 'catalog', 'no-image-200x200.png')}}" alt="{{$item['product']->name}}" class="card-order-media">
                    </a>
                </div>

                <div class="card-order-summary-container col-9 col-sm-10 col-lg">
                    <a href="{{UrlBuilder::getUrl($item['product'])}}" class="card-order-title">{!! $item['product']->name !!}</a>

                    <div class="card-order-info-list row align-items-center">
                        <div class="card-order-info-item col-md-auto">
{{--                            <label for="card-order-size-1" class="card-order-info-title d-inline-block font-weight-bold">????????????????????</label>--}}

{{--                            <select name="" id="card-order-size-1" class="card-order-size custom-control custom-select" style="width: auto;" >--}}
{{--                                <option value="50*60????">50*60????</option>--}}
{{--                                <option value="60*70????">60*70????</option>--}}
{{--                            </select>--}}
                        </div>

                        @if(count($item['color']))
                        <div class="card-order-info-item col-md-auto">
                            <span class="card-order-info-title d-inline-block font-weight-bold" >????????</span>

                            <div class="card-order-color-list d-inline-flex flex-wrap">
                                <div class="card-order-color custom-control custom-color custom-color-sm">
                                    <input type="radio" class="custom-control-input" id="card-order-color-1-1" name="card-order-color-1" checked >
                                    <label for="card-order-color-1-1" class="custom-control-label">
                                        <img loading="lazy" src="{{$item['color']['imgPath']}}" alt="{{$item['color']['name']}}" title="{{$item['color']['name']}}" class="custom-control-image">
                                    </label>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="card-order-info-item col-md-auto">
                            <span class="card-order-info-title d-inline-block" >??????????????</span>
                            <span class="card-order-vendor-code font-weight-bold" >{{$item['product']->article ?? '-----'}}</span>
                        </div>

                        <div class="card-order-info-item col-md-auto">
                            <span class="card-order-info-title d-inline-block" >?????? ????????????</span>
                            <span class="card-order-product-code font-weight-bold" >{{$item['product']->code_1c ?? '-----'}}</span>
                        </div>
                    </div>
                </div>

                <div class="card-order-price-container col-4 col-md-3 col-lg-auto offset-sm-2 offset-lg-0">
                    <div class="card-order-subtitle">??????????????????</div>

                    <div class="card-order-price-block d-flex flex-wrap">
                        <span class="card-product-price text-nowrap"> {!! Helper::priceFormat($item['product']->price) !!}<span class="rouble">??????.</span></span>
                        @if(!is_null($oldPrice = $item['product']->getOldPrice()))
                        <span class="card-product-old-price">{!! Helper::priceFormat($oldPrice) !!}<span class="rouble">??????.</span></span>
                        <div class="card-product-sale-price text-danger font-weight-bold">{!! $item['product']->sale_string !!}</div>
                        @endif
                    </div>
                </div>

                <div class="card-order-quantity-container col-4 col-sm-3 col-lg-auto">
                    <div class="card-order-subtitle">??????-????</div>

                    <div class="card-order-quantity-block">
                        <div class="custom-number custom-control d-flex align-items-center">
                            <button type="button" class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center" >
                                <svg class="custom-number-button-media" width="12" height="12">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-minus')}}"></use>
                                </svg>
                            </button>

                            <input type="number" class="custom-number-input update-product-count-in-cart"
                                   value="{{$item['count']}}"
                                   data-min-value="1"
                            >

                            <button type="button" class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center" >
                                <svg class="custom-number-button-media" width="12" height="12">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-plus')}}"></use>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                @include('client.cart._order_item_summary', ['summaryItem' => $item['finalProductPrice']])

                <div class="card-order-remove-container col-auto">
                    <button type="button"
                            class="card-order-control card-order-control-remove d-flex align-items-center justify-content-center"
                            data-cart-action="remove"
                    >
                        <svg class="card-order-control-media" width="25" height="28">
                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-trash')}}"></use>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        @if(count($item['services']))
            <div class="card-order-services-block">
                @isset($item['services']['add_keys'])
                    <div class="row">
                        <div class="card-order-included-block col-12 d-flex flex-wrap align-items-center">
                            <div class="card-order-include-thumbnail">
                                <svg class="card-order-include-media" width="29" height="29">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-key')}}"></use>
                                </svg>
                            </div>

                            <div class="card-order-include-title">?? ?????????????????? {{$item['countKeysInSet']}} {!! Lang::choice('????????|??????????|????????????', $item['countKeysInSet']) !!}. ?????????????? ??????????:</div>

                            <div class="card-order-include-quantity-block">
                                <div
                                    class="card-order-include-number custom-number custom-control d-flex align-items-center">
                                    <button type="button"
                                            class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center">
                                        <svg class="custom-number-button-media" width="12" height="12">
                                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-minus')}}"></use>
                                        </svg>
                                    </button>

                                    <input type="number" class="custom-number-input cart-add-keys-service-count"
                                           data-service-id="{{\App\Models\Service::ADD_KEYS_ID}}"
                                           value="{{$item['countAdditionalKeys']}}"
                                           data-min-value="{{$item['countAdditionalKeys']}}">

                                    <button type="button"
                                            class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center">
                                        <svg class="custom-number-button-media" width="12" height="12">
                                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-plus')}}"></use>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            @if(is_null($item['services']['add_keys']->price))
                                <span class="text-muted">(???????? ????????????????????)</span>
                                @else
                                <div class="card-order-include-price text-muted">
                                    (+ <span class="cart-add-keys-service-price" data-price="{{$item['services']['add_keys']->price}}">0</span>??)
                                </div>
                            @endif

                        </div>
                    </div>
                @endisset

                @isset($item['services']['general'])
                    <div class="row">
                        <div class="card-order-service-block col-12">
                            <div class="card-order-services-title">???????????????? ????????????
                                <button type="button" class="card-order-services-tooltip-toggle tooltip-toggle"
                                        data-toggle="tooltip" data-placement="right"
                                        title="????????????-????????????, ???? ????????????????????.">?
                                </button>
                            </div>

                            <ul class="card-order-services-list list-unstyled">

                                @foreach($item['services']['general'] as $key => $element)
                                <li class="card-order-service-item d-flex flex-wrap">
                                    <div class="card-order-service-checkbox custom-control custom-checkbox">

                                        <input type="checkbox"
                                               class="custom-control-input"
                                               id="card-order-service-{{$itemKey}}-{{$key}}"
                                               data-service-id="{{$element->id}}"
                                               @if(\Cart::checkService($item['product']->id,$element->id)) checked @endif
                                        >

                                        <label class="custom-control-label" for="card-order-service-{{$itemKey}}-{{$key}}">{{$element->name}}

                                            @if(is_null($element->price))
                                                <span class="text-muted">(???????? ????????????????????)</span>
                                            @else
                                                <span class="text-muted">(+ {{(int)$element->price}}??)</span>
                                            @endif

                                        </label>


                                        <a href="{{route('service.show', [$element->alias])}}" class="card-order-service-link text-nowrap">??????????????????
                                            ???? ????????????</a>
                                    </div>
                                </li>
                                @endforeach

                            </ul>
                        </div>
                    </div>
                @endisset
            </div>
        @endif

    </div>
</div>
