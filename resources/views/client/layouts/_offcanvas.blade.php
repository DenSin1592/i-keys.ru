<!-- Offcanvas -->
<div id="offcanvas" class="offcanvas d-xxl-none">
    <div class="offcanvas-header">
        <div class="form-row flex-nowrap align-items-center">
            <div class="offcanvas-toggle-container col-auto">
                <button type="button" class="offcanvas-close close">
                    <svg class="close-media" width="24" height="24">
                        <use xlink:href="{{'/images/client/sprite.svg#icon-close'}}"></use>
                    </svg>
                </button>
            </div>

            <div class="offcanvas-location-container col">
                <div class="offcanvas-location-block">
                    {{--<button type="button" class="offcanvas-location-toggle d-flex align-items-center" data-toggle="modal" data-target="#modalLocation">
                            <span class="offcanvas-location-thumbnail">
                                <svg class="offcanvas-location-media" width="27" height="16">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-location')}}"></use>
                                </svg>
                            </span>

                        <span class="offcanvas-location-text text-truncate">
                                <span class="offcanvas-location-region">{{$currentCity}}</span>
                        </span>
                    </button>--}}
                </div>
            </div>

            <div class="offcanvas-account-container col-auto">
                <ul class="offcanvas-account-list list-unstyled row">
                    <li class="offcanvas-account-item col-auto">
                        <a href="javascript:void(0);" class="offcanvas-account-link d-flex align-items-center">
                                <span class="offcanvas-account-thumbnail">
                                    <svg class="offcanvas-account-media" width="28" height="25">
                                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-compare')}}"></use>
                                    </svg>
                                </span>

                            <span
                                class="offcanvas-account-badge d-flex align-items-center justify-content-center">0</span>
                        </a>
                    </li>

                    <li class="offcanvas-account-item col-auto">
                        <a href="{{route('cart.show')}}" class="offcanvas-account-link d-flex align-items-center">
                                <span class="offcanvas-account-thumbnail">
                                    <svg class="offcanvas-account-media" width="28" height="25">
                                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-cart')}}"></use>
                                    </svg>
                                </span>

                            <span
                                class="offcanvas-account-badge d-flex align-items-center justify-content-center">{{$cartItemCount}}</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <div class="offcanvas-body">

        <div class="offcanvas-search-block">
            {{ Form::open(['url' => route('search'), 'class' => 'offcanvas-search search', 'method' => 'GET']) }}
                {{ Form::search('query', Request::get('query'), ['required' => '', 'placeholder' => 'Поиск товаров', 'class' => 'offcanvas-search-input search-input'])}}
                {{Form::hidden('category_for_search', Request::get('category_for_search', 'all'))}}

                <button type="submit" class="offcanvas-search-button search-button">
                    <svg class="search-button-media" width="24" height="25">
                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-search')}}"></use>
                    </svg>
                </button>
            {{ Form::close() }}
        </div>

        <div class="offcanvas-contact-block">
            <div class="form-row">
                <div class="col">
                    <ul class="offcanvas-contact-list list-unstyled">
                        @if(trim(Setting::get("site_content.phone")) !== '')
                            <li class="offcanvas-contact-item">
                                <a href="tel:{{ Setting::get("site_content.phone") }}"
                                   class="offcanvas-contact-link">{{ Setting::get("site_content.phone") }}</a>
                            </li>
                        @endif

                        @if(trim(Setting::get("mail.feedback.address")) !== '')
                            <li class="offcanvas-contact-item">
                                <a href="mailto:{{Setting::get("mail.feedback.address")}}"
                                   class="offcanvas-contact-link">{{Setting::get("mail.feedback.address")}}</a>
                            </li>
                        @endif
                    </ul>
                </div>


                <div class="col-auto">
                    @if(trim(Setting::get("site_content.wa_phone")) !== '')

                        <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}"
                           class="offcanvas-social-link d-flex align-items-center">
                            <span class="offcanvas-social-thumbnail">
                                <img loading="lazy" src="{{asset('/images/client/icons/icon-whatsapp.svg')}}" width="25"
                                     height="25"
                                     alt="WhatsApp" class="offcanvas-social-media">
                            </span>

                            <span class="offcanvas-social-text">WhatsApp</span>
                        </a>
                    @endif

                </div>
            </div>
        </div>

        <ul class="offcanvas-catalog-list list-unstyled">

            @foreach($categoriesHeaderMenu as $element)

                <li class="offcanvas-catalog-item {{ $element['active']  ? 'active' : '' }}">
                    <a href="{{$element['url']}}" class="offcanvas-catalog-link d-flex align-items-center">
                        <span class="offcanvas-catalog-thumbnail">
                            <svg class="header-catalog-media" width="26" height="26">
                                <use xlink:href="{{asset($element['image_path'])}}"></use>
                            </svg>
                        </span>

                        <span class="offcanvas-catalog-text">{{$element['name']}}</span>
                    </a>
                </li>
            @endforeach

        </ul>

        @if(count($topMenu) > 0)
            <ul class="offcanvas-nav-list list-unstyled">

                @foreach($topMenu as $menuElement)
                    <li class="offcanvas-nav-item {{ $menuElement['active']  ? 'active' : '' }}">
                        <a href="{{ $menuElement['url'] }}"
                           class="offcanvas-nav-link">{{$menuElement['name']}} </a>
                    </li>
                @endforeach

            </ul>
        @endif


    </div>
</div>
