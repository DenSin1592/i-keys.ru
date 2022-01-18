<header class="header-box flex-shrink-0 flex-grow-1 is-fixed compensate-for-scrollbar">
    <div class="container">
        <div class="row flex-nowrap flex-md-wrap align-items-center">
            <div class="header-location-container col-auto d-none d-lg-block">
                {{--<button type="button" class="header-location-toggle d-flex align-items-center">
                    <div class="header-location-thumbnail d-none d-xl-block">
                        <img loading="lazy" src="{{asset('/images/client/icons/icon-location.svg')}}" width="27"
                             height="16" alt="" class="header-location-medua">
                    </div>

                    <div class="header-location-text text-truncate">
                        <div class="header-location-region">{{$currentCity}}</div>
                    </div>
                </button>--}}
            </div>

            <div class="header-burger-container col-auto d-xxl-none">
                <button type="button" class="header-burger-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>


            <div class="header-nav-container col-auto d-none d-xxl-block">
                @if(count($topMenu) > 0)
                    <ul class="header-nav-list list-unstyled d-flex flex-wrap">

                        @foreach($topMenu as $menuElement)
                            <li class="header-nav-item {{ $menuElement['active']  ? 'active' : '' }}">
                                <a href="{{ $menuElement['url'] }}"
                                   class="header-nav-link">{{ $menuElement['name'] }}</a>
                            </li>
                        @endforeach

                    </ul>
                @endif
            </div>


            <div class="header-logo-container col col-md-auto order-lg-1">
                <a href="{{route('home')}}" class="header-logo d-flex align-items-center">
                    <div class="header-logo-thumbnail">
                        <img src="{{asset('/images/client/logo/logo-dark.svg')}}" width="52" height="44" alt=""
                             class="header-logo-media">
                    </div>

                    <div class="header-logo-text">
                        <div class="header-logo-title">Замки <br class="d-xl-none"> и Ключи</div>
                        <div class="header-logo-subtitle d-none d-xl-block">Магазин дверных замков и фурнитуры</div>
                    </div>
                </a>
            </div>


            <div class="header-contact-container col-auto d-none d-md-block mx-md-auto">
                <ul class="header-contact-list list-unstyled align-items-center row">
                    @if(trim(Setting::get("site_content.phone")) !== '')
                        <li class="header-contact-item col-auto">
                            <a href="tel:{{ Setting::get("site_content.phone") }}" class="header-contact">{{ Setting::get("site_content.phone") }}</a>
                        </li>
                    @endif

                    @if(trim(Setting::get("mail.feedback.address")) !== '')
                        <li class="header-contact-item col-auto d-none d-lg-block">
                            <a href="mailto:{{Setting::get("mail.feedback.address")}}" class="header-contact">{{Setting::get("mail.feedback.address")}}</a>
                        </li>
                    @endif
                </ul>
            </div>


            <div class="header-social-container col-auto mx-md-auto">

                @if(trim(Setting::get("site_content.wa_phone")) !== '')
                <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}" target="_blank" class="header-social header-social-whatsapp d-flex align-items-center">
                    <div class="header-social-thumbnail">
                        <img loading="lazy" src="{{asset('/images/client/icons/icon-whatsapp.svg')}}" width="25"
                             height="25" alt="WhatsApp" class="header-social-media">
                    </div>

                    <div class="header-social-text d-none d-md-block"><span
                            class="d-none d-xxl-inline">Связаться по</span> WhatsApp
                    </div>
                </a>
                @endif

            </div>

            <div class="header-search-container col-auto d-none d-sm-block mx-md-auto">
                <button type="button" class="header-search-toggle d-flex d-lg-none align-items-center">
                        <span class="header-search-thumbnail">
                            <svg class="header-search-media" width="24" height="25">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-search')}}"></use>
                            </svg>
                        </span>

                    <span class="header-search-text">Поиск</span>
                </button>

                {{ Form::open(['url' => route('search'), 'class' => 'header-search search d-none d-lg-block', 'method' => 'GET']) }}
                    {{ Form::search('query', Request::get('query'), ['required' => '', 'placeholder' => 'Поиск товаров', 'class' => 'header-search-input search-input'])}}

                    <button type="submit" class="header-search-button search-button">
                        <svg class="search-button-media" width="24" height="25">
                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-search')}}"></use>
                        </svg>
                    </button>
                {{ Form::close() }}
            </div>

            <div class="header-account-container col-auto">
                <ul class="header-account-list list-unstyled row">
                    <li class="header-account-item col-auto d-none d-sm-block">
                        <a href="javascript:void(0);" class="header-account d-flex align-items-center">
                            <div class="header-account-thumbnail">
                                <svg class="header-account-media" width="28" height="25">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-compare')}}"></use>
                                </svg>
                            </div>


                            <div class="header-account-badge d-flex align-items-center justify-content-center">0</div>
                        </a>
                    </li>

                    <li class="header-account-item col-auto">
                        <a href="{{route('cart.show')}}" class="header-account d-flex align-items-center">
                            <div class="header-account-thumbnail">
                                <svg class="header-account-media" width="28" height="25">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-cart')}}"></use>
                                </svg>
                            </div>

                            <div class="header-account-badge d-flex align-items-center justify-content-center cart-item-count">{{$cartItemCount}}</div>
                        </a>
                    </li>
                </ul>
            </div>

            <div class="header-devider w-100 d-none d-md-block"></div>

            <div class="header-catalog-container col d-none d-md-block order-lg-2">
                <ul class="header-catalog-list list-unstyled no-gutters d-flex flex-wrap justify-content-between">

                    @foreach($categoriesHeaderMenu as $element)
                    <li class="header-catalog-item col-auto col-xxl {{ $element['active']  ? 'active' : '' }}">
                        <a href="{{$element['url']}}" class="header-catalog-link d-flex align-items-center justify-content-center">
                            <div class="header-catalog-thumbnail">
                                <svg class="header-catalog-media" width="26" height="25">
                                    <use xlink:href="{{asset($element['image_path'])}}"></use>
                                </svg>
                            </div>

                            <div class="header-catalog-text">{{$element['name']}}</div>
                        </a>
                    </li>
                    @endforeach

                </ul>
            </div>
        </div>
    </div>
</header>

