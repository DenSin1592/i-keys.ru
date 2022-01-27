<footer class="footer-box section-dark flex-shrink-0 flex-grow-0">
    <div class="container">
        <div class="row d-lg-block d-xxl-flex">
            <div class="footer-logo-container col-sm-6 col-md-4 col-lg-2 col-xl-auto col-xxl-3 align-self-center order-md-1 float-lg-left">
                <a href="{{route('home')}}" class="footer-logo d-flex align-items-center">
                    <div class="footer-logo-thumbnail">
                        <img src="{{asset('/images/client/logo/logo-light.svg')}}" width="52" height="44" alt="Замки и Ключи" class="footer-logo-media">
                    </div>

                    <div class="footer-logo-text">
                        <div class="footer-logo-title">Замки <br class="d-xl-none" > и Ключи</div>
                        <div class="footer-logo-subtitle d-none d-xl-block">Магазин дверных замков и фурнитуры</div>
                    </div>
                </a>
            </div>

            <div class="footer-catalog-container col-lg-10 col-xl-auto col-xxl d-none d-lg-block order-md-2 float-lg-right">
                <ul class="footer-catalog-list list-unstyled no-gutters d-flex flex-wrap justify-content-between">

                    @foreach($categoriesFooterMenu as $element)
                        <li class="footer-catalog-item col-auto col-xxl  {{ $element['active']  ? 'active' : '' }}">
                            <a href="{{$element['url']}}" class="footer-catalog-link d-flex align-items-center justify-content-center">
                                <div class="footer-catalog-thumbnail">
                                    <svg class="footer-catalog-media" width="26" height="25">
                                        <use xlink:href="{{asset($element['image_path'])}}"></use>
                                    </svg>
                                </div>

                                <div class="footer-catalog-text">{{$element['name']}}</div>
                            </a>
                        </li>
                    @endforeach

                </ul>
            </div>

            <div class="footer-devider w-100 clearfix d-none d-lg-block order-md-3"></div>

            <div class="footer-copyright-container col-sm-6 col-md-4 col-lg-3 col-xl-2 order-md-6 order-lg-4 float-lg-left">
                <div class="footer-copyright-block">
                    <div class="footer-copyright-text">
                        <p>&copy;&nbsp;{{date('Y')}}</p>
                        <p>Все права защищены, при любом копировании материалов ссылка на сайт источник обязательна</p>
                    </div>
                </div>
            </div>


            <div class="footer-nav-container col-lg-2 col-xl-3 col-xxl-2 offset-xxl-1 d-none d-lg-block order-md-5 float-lg-left">
                @if(count($bottomMenu) > 0)
                <ul class="footer-nav-list list-unstyled d-flex flex-column flex-wrap">

                    @foreach($bottomMenu as $menuElement)
                        <li class="footer-nav-item {{ $menuElement['active']  ? 'active' : '' }}">
                            <a href="{{ $menuElement['url'] }}"
                               class="footer-nav-link">{!! $menuElement['name'] !!}</a>
                        </li>
                    @endforeach

                </ul>
                @endif
            </div>


            <div class="footer-contact-container col-md-8 col-lg-3 order-md-4 order-lg-6 float-lg-left">
                <div class="row">
                    <div class="footer-phone-container col-sm-6 col-lg-12">
                        <ul class="footer-contact-list d-flex flex-column list-unstyled">
                            @if(trim(Setting::get("site_content.phone")) !== '')
                                <li class="footer-contact-item col-auto">
                                    <a href="tel:{{ Setting::get("site_content.phone") }}" class="footer-contact">{{ Setting::get("site_content.phone") }}</a>
                                </li>
                            @endif

                            @if(trim(Setting::get("mail.feedback.address")) !== '')
                                <li class="footer-contact-item col-auto d-none d-lg-block">
                                    <a href="mailto:{{Setting::get("mail.feedback.address")}}" class="footer-contact">{{Setting::get("mail.feedback.address")}}</a>
                                </li>
                            @endif
                        </ul>
                    </div>

                    <div class="footer-social-container col-sm-6 col-lg-12">
                        <div class="footer-social-block">
                            @if(trim(Setting::get("site_content.wa_phone")) !== '')
                                <a href="https://wa.me/{{Setting::get("site_content.wa_phone")}}" target="_blank" class="footer-social footer-social-whatsapp d-flex align-items-center">
                                    <div class="footer-social-thumbnail">
                                        <img src="{{asset('/images/client/icons/icon-whatsapp.svg')}}" width="25" height="25" alt="WhatsApp" class="footer-social-media">
                                    </div>

                                    <div class="footer-social-text">Связаться по WhatsApp</div>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-search-container col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-2 offset-xl-1 offset-xxl-0 col order-md-7 float-lg-left">
                <form class="footer-search search">
                    <input type="search" class="footer-search-input search-input" placeholder="Поиск товаров" required="">
                    <button type="button" class="footer-search-button search-button">
                        <svg class="search-button-media" width="24" height="25">
                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-search')}}"></use>
                        </svg>
                    </button>
                </form>
            </div>

            <div class="footer-develop-container col-sm-6 col-md-4 col-lg-4 col-xl-3 col-xxl-1 offset-xl-1 order-md-8 float-lg-right">
                <a href="https://www.diol-it.ru/" class="footer-develop-link d-flex align-items-center align-items-xxl-end flex-xxl-column" target="_blank" >
                    <div class="footer-develop-text text-nowrap">Разработка сайта</div>

                    <div class="footer-develop-thumbnail">
                        <img loading="lazy" src="{{asset('/images/admin/diol.svg')}}" width="66" height="39" alt="Diol-it" class="footer-develop-image">
                    </div>
                </a>
            </div>
        </div>
    </div>
</footer>
