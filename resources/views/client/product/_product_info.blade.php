<section class="section-product-intro">
    <div class="container">
        <div class="product-intro-grid row">
            <div class="product-display-container col-12 section-dark"
                 style="background-image: url('{{asset('uploads/product/product-display-bg.jpg')}}');">

                @include('client.shared.breadcrumbs._breadcrumbs')

                <div class="product-display">
                    <div class="product-display-category title-h1">{{$productData['product']->category->name}}</div>
                    <h1>{{ $metaData['h1'] }}</h1>
                </div>

                <div class="product-info-block">
                    <div class="form-row">
                        <div class="col-auto">
                            <ul class="product-info-list list-unstyled row">
                                <li class="product-info-item col-auto">
                                    <span class="product-info-title">Артикул</span>
                                    <span class="product-info-value font-weight-bold">-----</span>
                                </li>

                                <li class="product-info-item col-auto">
                                    <span class="product-info-title">Код товара</span>
                                    <span
                                        class="product-info-value product-code">{{$productData['product']->code_1c}}</span>
                                </li>
                            </ul>
                        </div>

                        <div class="col-auto">
                            <div class="product-rating-block rating-block d-flex align-items-center">
                                <div class="rating-list d-flex align-items-center">
                                    <svg class="rating-star-media" width="22" height="22">
                                        <use xlink:href=""></use>
                                    </svg>
                                    @for($i = 1; $i <= 5; $i++)
                                        <svg class="rating-star-media" width="22" height="22">
                                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-star')}}"></use>
                                        </svg>
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product-thumbnail-container col-12">
                <div class="form-row">
                    <div class="product-gallery-slider-container col-12 col-sm-8 col-md-12 order-sm-1 order-md-0">
                        <div class="swiper-product-gallery swiper-container">
                            <div class="swiper-wrapper">
                                @forelse($productData['images'] as $element)
                                    <div class="swiper-slide">
                                        <a href="{{$element->getImgPath('image', 'catalog', 'no-image-800x800.png')}}"
                                           class="product-media-link" data-fancybox="product-media">
                                            <img loading="lazy"
                                                 src="{{$element->getImgPath('image', 'catalog', 'no-image-800x800.png')}}"
                                                 width="275" height="278" alt="{{$productData['product']->name}}"
                                                 class="product-media">
                                        </a>
                                    </div>
                                @empty
                                    <div class="swiper-slide">
                                        <a href="#" class="product-media-link">
                                            <img loading="lazy"
                                                 src="{{asset('/images/common/no-image/no-image-200x200.png')}}"
                                                 width="275" height="278" alt="{{$productData['product']->name}}"
                                                 class="product-media">
                                        </a>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    <div class="product-gallery-thumbnails-container col-12 col-sm-2 col-md-12 order-sm-0 order-md-1">
                        <div class="form-row">
                            <div class="col col-sm-12 col-lg flex-grow-1">
                                <div class="swiper-product-thumbnails-cover d-inline-block">
                                    <div class="swiper-product-thumbnails swiper-container">

                                        @if($productData['images']->count() > 1)
                                            <div class="swiper-wrapper">
                                                @foreach($productData['images'] as $element)
                                                    <div class="swiper-slide">
                                                        <div class="product-thumbnail">
                                                            <img loading="lazy"
                                                                 src="{{$element->getImgPath('image', 'catalog', 'no-image-200x200.png')}}"
                                                                 width="47" height="47"
                                                                 alt="{{$productData['product']->name}}"
                                                                 class="product-thumbnail-media">
                                                        </div>
                                                    </div>
                                                @endforeach

                                            </div>

                                            <button type="button"
                                                    class="swiper-product-thumbnails-button-prev swiper-button-prev">
                                                <svg class="swiper-button-media" width="16" height="16">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-angle-left')}}"></use>
                                                </svg>
                                            </button>

                                            <button type="button"
                                                    class="swiper-product-thumbnails-button-next swiper-button-next">
                                                <svg class="swiper-button-media" width="16" height="16">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-angle-right')}}"></use>
                                                </svg>
                                            </button>
                                        @endif

                                    </div>
                                </div>
                            </div>

                            {{--                            <div class="col-auto col-sm-12 col-lg-auto">--}}
                            {{--                                <a href="https://www.youtube.com/watch?v=-_aWml_EokU&autoplay=1"--}}
                            {{--                                   class="product-presentation-link d-flex flex-column flex-md-row flex-lg-column align-items-center justify-content-center"--}}
                            {{--                                   data-fancybox="product-media">--}}
                            {{--                                    <img loading="lazy" src="images/icons/icon-youtube.svg" width="42" height="30"--}}
                            {{--                                         alt="" class="product-presentation-media">--}}
                            {{--                                    Видео о замке--}}
                            {{--                                </a>--}}
                            {{--                            </div>--}}
                        </div>
                    </div>

                    {{--                    <div class="product-badges-container col-auto order-2">--}}
                    {{--                        <div class="product-badges d-flex flex-column align-items-center">--}}
                    {{--                            <div class="product-badge">--}}
                    {{--                                <svg class="product-badge-media" width="44" height="44">--}}
                    {{--                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-sale')}}"></use>--}}
                    {{--                                </svg>--}}
                    {{--                            </div>--}}

                    {{--                            <div class="product-badge">--}}
                    {{--                                <svg class="product-badge-media" width="48" height="44">--}}
                    {{--                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-anti-fake')}}"></use>--}}
                    {{--                                </svg>--}}
                    {{--                            </div>--}}

                    {{--                            <div class="product-badge">--}}
                    {{--                                <svg class="product-badge-media" width="39" height="44">--}}
                    {{--                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-coding')}}"></use>                                </svg>--}}
                    {{--                            </div>--}}

                    {{--                            <div class="product-badge">--}}
                    {{--                                <svg class="product-badge-media" width="44" height="44">--}}
                    {{--                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-no-keys')}}"></use>                                </svg>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                </div>
            </div>

            <div class="product-typography-container col-12 section-dark">
                <form action="" class="form-product-order">
                    <div class="row">
                        <div class="product-details-container col-sm-6 col-lg-5">
                            <div class="product-detail-block d-flex flex-wrap">
                                <span class="product-detail-title">Цвет</span>

                                <div class="product-color-list d-flex flex-wrap">
                                    <div class="product-color custom-control custom-color">
                                        <input type="radio" class="custom-control-input" id="product-color-1"
                                               name="product-color" checked="">
                                        <label for="product-color-1" class="custom-control-label">
                                            <img loading="lazy" src="{{asset('/uploads/colors/color-brown.png')}}"
                                                 alt="Коричневый"
                                                 class="custom-control-image">
                                        </label>
                                    </div>

                                    <div class="product-color custom-control custom-color">
                                        <input type="radio" class="custom-control-input" id="product-color-2"
                                               name="product-color">
                                        <label for="product-color-2" class="custom-control-label">
                                            <img loading="lazy"
                                                 src="{{asset('/uploads/colors/color-silver.png')}}"
                                                 alt="Серебряный"
                                                 class="custom-control-image">
                                        </label>
                                    </div>

                                    <div class="product-color custom-control custom-color">
                                        <input type="radio" class="custom-control-input" id="product-color-3"
                                               name="product-color">
                                        <label for="product-color-3" class="custom-control-label">
                                            <img loading="lazy" src="{{asset('/uploads/colors/color-black.png')}}"
                                                 alt="Черный"
                                                 class="custom-control-image">
                                        </label>
                                    </div>
                                </div>
                            </div>

                            @if($productData['product']->isCylinder())
                                <div class="product-detail-block d-flex flex-wrap">
                                            <span class="product-detail-title">Типоразмер
                                                <span class="d-none d-xxl-inline text-muted">(Выберите нужный)</span>
                                                <button type="button"
                                                        class="product-detail-tooltip-toggle tooltip-toggle"
                                                        data-toggle="tooltip" data-placement="right" title=""
                                                        data-original-title="Далеко-далеко, за словесными.">?</button>
                                            </span>

                                    <div class="product-scheme-block product-scheme-type-1">
                                        <div class="product-scheme-options-block">
                                            <div class="row flex-nowrap no-gutters">
                                                <div class="product-scheme-option-column col-5">
                                                    <div class="product-scheme-option-group">
                                                        <label for="product-scheme-option-1"
                                                               class="product-scheme-option-title">Внеш.</label>

                                                        <select name="" id="product-scheme-option-1"
                                                                class="product-scheme-option-select custom-control custom-select"
                                                                style="width: 100%;">
                                                            <option value="30мм">30мм</option>
                                                            <option value="40мм">40мм</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="product-scheme-option-column col-7">
                                                    <div class="product-scheme-option-group">
                                                        <label for="product-scheme-option-2"
                                                               class="product-scheme-option-title">Внутр.</label>

                                                        <select name="" id="product-scheme-option-2"
                                                                class="product-scheme-option-select custom-control custom-select"
                                                                style="width: 100%;">
                                                            <option value="75мм">75мм</option>
                                                            <option value="85мм">85мм</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="product-scheme-thumbnail">
                                            <img loading="lazy"
                                                 src="{{asset('images/client/scheme/product-scheme-type-1.png')}}"
                                                 width="262"
                                                 height="106" alt="" class="product-scheme-media">
                                        </div>
                                    </div>
                                </div>

                                <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}"
                                   class="product-whatsapp-block d-flex">
                                            <span class="product-whatsapp-thumbnail">
                                                <img loading="lazy"
                                                     src="{{asset('/images/client/icons/icon-whatsapp.svg')}}"
                                                     width="25"
                                                     height="25" alt="WhatsApp" class="product-whatsapp-media">
                                            </span>

                                    <span class="product-whatsapp-content">
                                                <span class="product-whatsapp-description">Здесь важно не ошибиться, напишите нам в whatsapp, мы поможем</span>
                                            </span>
                                </a>
                            @endif
                        </div>

                        <div class="product-order-container col-sm-6 col-lg-7">
                            <div class="product-order-block">
                                <div class="product-status-block">
                                                <span class="product-status product-available d-inline-block">
                                                    <svg class="product-status-media" width="14" height="10">
                                                        <use
                                                            xlink:href="{{asset('/images/client/sprite.svg#icon-check')}}"></use>
                                                    </svg>
                                                   {{$productData['product']->getExistenceString()}}
                                                </span>
                                </div>

                                <span
                                    class="product-price">{!! Helper::priceFormat($productData['product']->price) !!}<span
                                        class="rouble"></span></span>

                                @if(!is_null($oldPrice = $productData['product']->getOldPrice()))
                                    <span
                                        class="product-old-price text-muted">{!! Helper::priceFormat($oldPrice) !!}<span
                                            class="rouble"></span></span>
                                    <span
                                        class="product-sale-price font-weight-bold text-danger">{{$productData['product']->sale_string}}</span>
                                    <span class="product-sale-hint d-block">Распродажа в связи с обновлением ассортимента</span>
                                @endif
                            </div>

                            <div class="product-controls-block">
                                <div class="form-row">
                                    <div class="col">
                                        @if ($productData['product']->price > 0.0)
                                            @if(\App\Facades\Cart::checkItem($productData['product']->id))
                                                @include('client.shared.product.button._in_cart')
                                            @else
                                                @include('client.shared.product.button._add_to_card', ['product' => $productData['product']])
                                            @endif
                                        @endif
                                    </div>

                                    <div class="col-auto">
                                        <button type="button"
                                                class="product-control product-control-compare btn btn-lg btn-secondary font-weight-normal"
                                                data-toggle="modal" data-target="#modalAddToCompare">
                                            <svg class="product-control-media" width="24" height="25">
                                                <use
                                                    xlink:href="{{asset('/images/client/sprite.svg#icon-compare')}}"></use>
                                            </svg>

                                            <span class="product-control-text d-none d-lg-inline">Сравнить</span>
                                        </button>
                                    </div>

                                    <div class="col-12">
                                        <div class="product-controls-hint text-danger">
                                            <span class="product-controls-hint-media">!</span>
                                            Только по предоплате
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($productData['count_keys_in_set'])
                                <div class="product-included-block">

                                    <svg class="product-included-media" width="20" height="20">
                                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-key')}}"></use>
                                    </svg>

                                    <span
                                        class="product-included-title">В комплекте <b>{{$productData['count_keys_in_set']}}</b> {{\Lang::choice('ключ|ключа|ключей', $productData['count_keys_in_set'])}}</span>

                                    <button type="button" class="product-included-toggle" data-toggle="modal"
                                            data-target="#modalKeysQuantity">Добавить еще ключи на всю семью
                                    </button>

                                </div>
                            @endif
                            <div class="product-delivery-block d-flex align-items-center">
                                <img src="{{asset('/images/client/icons/icon-delivery-light.png')}}"
                                     class="product-delivery-media"
                                     width="40" height="20" alt="">
                                <!-- <span class="product-delivery-thumbnail">
                                    <svg class="product-delivery-media" width="40" height="20">
                                        <use xlink:href="/images/sprite.svg#icon-delivery"></use>
                                    </svg>
                                </span> -->

                                <span class="product-delivery-content">
                                    Доставка по
                                    <button type="button" class="product-delivery-toggle"
                                            data-toggle="modal" data-target="#modalLocation">Москве</button> <br
                                        class="d-lg-none"> <b>1-2 дня от 450 руб</b>
                                </span>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
