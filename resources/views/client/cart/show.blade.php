@extends('client.layouts.default')


@section('body_class')
    class='cart-page d-flex flex-column'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">
        <section class="section-display section-dark" >
            <div class="container">
                @include('client.shared.breadcrumbs._breadcrumbs')

                <h1 class="display-title title-h1 text-uppercase">{{ $metaData['h1'] }}</h1>
                <div class="display-subtitle title-h4">В корзине 12 товаров, 2 услуги на сумму 2 500 р.</div>
            </div>
        </section>

        <section class="section-cart section-gray">
            <div class="container">
                <div class="order-list">
                    <div class="order-item">
                        <div class="card-order">
                            <div class="card-order-inner">
                                <div class="row align-items-lg-center">
                                    <div class="card-order-thumbnail-container col-3 col-sm-2 col-lg-auto">
                                        <div class="card-order-badges-block d-flex">
                                            <div class="card-order-badge">
                                                <svg class="card-order-badge-media" width="39" height="45">
                                                    <use xlink:href="/images/sprite.svg#icon-coding"></use>
                                                </svg>
                                            </div>

                                            <div class="card-order-badge">
                                                <svg class="card-order-badge-media" width="45" height="45">
                                                    <use xlink:href="/images/sprite.svg#icon-no-keys"></use>
                                                </svg>
                                            </div>
                                        </div>

                                        <a href="product.html" class="card-order-thumbnail d-flex align-items-center justify-content-center">
                                            <img src="uploads/catalog/product-image-1.jpg" alt="Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01" class="card-order-media">
                                        </a>
                                    </div>

                                    <div class="card-order-summary-container col-9 col-sm-10 col-lg">
                                        <a href="product.html" class="card-order-title">Цилиндр с вертушкой Фабрика замков E AL 60 CP Т01</a>

                                        <div class="card-order-info-list row align-items-center">
                                            <div class="card-order-info-item col-md-auto">
                                                <label for="card-order-size-1" class="card-order-info-title d-inline-block font-weight-bold">Типоразмер</label>

                                                <select name="" id="card-order-size-1" class="card-order-size custom-control custom-select" style="width: auto;" >
                                                    <option value="50*60мм">50*60мм</option>
                                                    <option value="60*70мм">60*70мм</option>
                                                </select>
                                            </div>

                                            <div class="card-order-info-item col-md-auto">
                                                <span class="card-order-info-title d-inline-block font-weight-bold" >Цвет</span>

                                                <div class="card-order-color-list d-inline-flex flex-wrap">
                                                    <div class="card-order-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-order-color-1-1" name="card-order-color-1" checked >
                                                        <label for="card-order-color-1-1" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-brown.png" alt="Коричневый" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-order-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-order-color-1-2" name="card-order-color-1" >
                                                        <label for="card-order-color-1-2" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-silver.png" alt="Серебряный" class="custom-control-image">
                                                        </label>
                                                    </div>

                                                    <div class="card-order-color custom-control custom-color custom-color-sm">
                                                        <input type="radio" class="custom-control-input" id="card-order-color-1-3" name="card-order-color-1" >
                                                        <label for="card-order-color-1-3" class="custom-control-label">
                                                            <img loading="lazy" src="uploads/colors/color-black.png" alt="Черный" class="custom-control-image">
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="card-order-info-item col-md-auto">
                                                <span class="card-order-info-title d-inline-block" >Артикул</span>
                                                <span class="card-order-vendor-code font-weight-bold" >PD-01-63</span>
                                            </div>

                                            <div class="card-order-info-item col-md-auto">
                                                <span class="card-order-info-title d-inline-block" >Код товара</span>
                                                <span class="card-order-product-code font-weight-bold" >20688</span>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-order-price-container col-4 col-md-3 col-lg-auto offset-sm-2 offset-lg-0">
                                        <div class="card-order-subtitle">Стоимость</div>

                                        <div class="card-order-price-block d-flex flex-wrap">
                                            <span class="card-product-price">187<span class="rouble"></span></span>
                                            <span class="card-product-old-price">499<span class="rouble"></span></span>
                                            <div class="card-product-sale-price text-danger font-weight-bold">Экономия 13%</div>
                                        </div>
                                    </div>

                                    <div class="card-order-quantity-container col-4 col-sm-3 col-lg-auto">
                                        <div class="card-order-subtitle">Кол-во</div>

                                        <div class="card-order-quantity-block">
                                            <div class="custom-number custom-control d-flex align-items-center">
                                                <button type="button" class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center" >
                                                    <svg class="custom-number-button-media" width="12" height="12">
                                                        <use xlink:href="/images/sprite.svg#icon-minus"></use>
                                                    </svg>
                                                </button>

                                                <input type="number" class="custom-number-input" value="1" >

                                                <button type="button" class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center" >
                                                    <svg class="custom-number-button-media" width="12" height="12">
                                                        <use xlink:href="/images/sprite.svg#icon-plus"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-order-total-container col-4 col-sm-3 col-lg-auto">
                                        <div class="card-order-subtitle">Итого</div>

                                        <div class="card-order-total-block">
                                            <span class="card-product-total-price">187<span class="rouble"></span></span>
                                        </div>
                                    </div>

                                    <div class="card-order-remove-container col-auto">
                                        <button type="button" class="card-order-control card-order-control-remove d-flex align-items-center justify-content-center" >
                                            <svg class="card-order-control-media" width="25" height="28">
                                                <use xlink:href="/images/sprite.svg#icon-trash"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div class="card-order-services-block">
                                <div class="row">
                                    <div class="card-order-included-block col-12 d-flex flex-wrap align-items-center">
                                        <div class="card-order-include-thumbnail">
                                            <svg class="card-order-include-media" width="29" height="29">
                                                <use xlink:href="/images/sprite.svg#icon-key"></use>
                                            </svg>
                                        </div>

                                        <div class="card-order-include-title">В комплекте</div>

                                        <div class="card-order-include-quantity-block">
                                            <div class="card-order-include-number custom-number custom-control d-flex align-items-center">
                                                <button type="button" class="custom-number-button custom-number-decrease d-flex align-items-center justify-content-center">
                                                    <svg class="custom-number-button-media" width="12" height="12">
                                                        <use xlink:href="/images/sprite.svg#icon-minus"></use>
                                                    </svg>
                                                </button>

                                                <input type="number" class="custom-number-input" value="1">

                                                <button type="button" class="custom-number-button custom-number-increase d-flex align-items-center justify-content-center">
                                                    <svg class="custom-number-button-media" width="12" height="12">
                                                        <use xlink:href="/images/sprite.svg#icon-plus"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <div class="card-order-include-price text-muted">(+ 300р)</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="card-order-service-block col-12">
                                        <div class="card-order-services-title">Добавить услуги <button type="button" class="card-order-services-tooltip-toggle tooltip-toggle" data-toggle="tooltip" data-placement="right" title="Далеко-далеко, за словесными.">?</button></div>

                                        <ul class="card-order-services-list list-unstyled">
                                            <li class="card-order-service-item d-flex flex-wrap">
                                                <div class="card-order-service-checkbox custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="card-order-service-1-1">
                                                    <label class="custom-control-label" for="card-order-service-1-1">Установка замка <span class="text-muted" >(Цена договорная)</span></label>
                                                    <a href="#link" class="card-order-service-link text-nowrap" >Подробнее об услуге</a>
                                                </div>
                                            </li>

                                            <li class="card-order-service-item d-flex flex-wrap">
                                                <div class="card-order-service-checkbox custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input" id="card-order-service-1-2">
                                                    <label class="custom-control-label" for="card-order-service-1-2">Взлом старого замка <span class="text-muted" >(Цена договорная)</span></label>
                                                    <a href="#link" class="card-order-service-link text-nowrap" >Подробнее об услуге</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="cart-controls">
                        <div class="row align-items-center">
                            <div class="col-md-auto d-flex flex-column flex-md-row">
                                <button type="button" class="cart-control cart-control-confirm btn btn-lg">Оформить заказ</button>
                            </div>

                            <div class="col-md">
                                <div class="cart-fast-order-block">
                                    <button type="button" class="cart-fast-order-link btn btn-link" data-toggle="modal" data-target="#modalQuickOrder" >Быстрый заказ</button>
                                    <div class="cart-fast-order-hint">Менеджер уточнит всю информацию по телефону</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section-checkout">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="checkout-header">
                            <div class="checkout-title title-h3 text-uppercase">Оформление заказа</div>
                            <div class="checkout-subtitle title-h4 font-weight-bold">Вы заказали 12 товаров на сумму 2 500 р и 2 услуги</div>
                        </div>

                        <div class="checkout-accordion" id="checkout-accordion">
                            <div class="row">
                                <div class="col-lg-3 d-none d-lg-block">
                                    <div class="checkout-nav-list d-flex flex-column">
                                        <button class="checkout-nav-link d-flex align-items-center" type="button" data-toggle="collapse"
                                                data-target="#checkout-information-collapse" aria-expanded="true" aria-controls="checkout-information-collapse">
                                            <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">1</span>
                                            Личная информация
                                        </button>

                                        <button class="checkout-nav-link d-flex align-items-center collapsed" type="button" data-toggle="collapse"
                                                data-target="#checkout-delivery-collapse" aria-expanded="false" aria-controls="checkout-delivery-collapse">
                                            <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">2</span>
                                            Доставка
                                        </button>

                                        <button class="checkout-nav-link d-flex align-items-center collapsed" type="button" data-toggle="collapse"
                                                data-target="#checkout-payment-collapse" aria-expanded="false" aria-controls="checkout-payment-collapse">
                                            <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">3</span>
                                            Оплата
                                        </button>

                                        <button class="checkout-nav-link d-flex align-items-center collapsed" type="button" data-toggle="collapse"
                                                data-target="#checkout-confirm-collapse" aria-expanded="false" aria-controls="checkout-confirm-collapse">
                                            <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">4</span>
                                            Подтверждение заказа
                                        </button>
                                    </div>
                                </div>

                                <div class="col-lg-9">
                                    <div class="checkout-group">
                                        <div class="checkout-headline d-lg-none">
                                            <button class="checkout-nav-link d-flex align-items-center" type="button" data-toggle="collapse"
                                                    data-target="#checkout-information-collapse" aria-expanded="true" aria-controls="checkout-information-collapse">
                                                <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">1</span>
                                                Личная информация
                                            </button>
                                        </div>

                                        <div id="checkout-information-collapse" class="checkout-collapse collapse show" data-parent="#checkout-accordion">
                                            <div class="checkout-content">
                                                <div class="form-group">
                                                    <input type="text" class="form-control" placeholder="Имя" >
                                                </div>

                                                <div class="form-group">
                                                    <input type="tel" class="form-control" placeholder="Телефон *" required >
                                                </div>

                                                <div class="form-group">
                                                    <input type="email" class="form-control" placeholder="Почта *" >
                                                </div>

                                                <div class="form-hint text-danger"><span class="form-hint-media" >!</span> Укажите реальную почту, на нее мы вам пришлем номер заказа и его детали, а также ссылку для оплаты</div>
                                            </div>

                                            <div class="checkout-controls">
                                                <div class="row align-items-center">
                                                    <div class="col-md-auto">
                                                        <div class="form-row flex-column flex-md-row">
                                                            <div class="col-md-auto">
                                                                <button type="button" class="checkout-control checkout-control-next btn btn-lg" >Перейти к следующему шагу</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="cart-fast-order-block">
                                                            <button type="button" class="cart-fast-order-link btn btn-link" data-toggle="modal" data-target="#modalQuickOrder" >Быстрый заказ</button>
                                                            <div class="cart-fast-order-hint">Менеджер уточнит всю информацию по телефону</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="checkout-group">
                                        <div class="checkout-headline d-lg-none">
                                            <button class="checkout-nav-link d-flex align-items-center collapsed" type="button" data-toggle="collapse"
                                                    data-target="#checkout-delivery-collapse" aria-expanded="false" aria-controls="checkout-delivery-collapse">
                                                <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">2</span>
                                                Доставка
                                            </button>
                                        </div>

                                        <div id="checkout-delivery-collapse" class="collapse" data-parent="#checkout-accordion">
                                            <div class="checkout-content">
                                                <div class="form-options-group">
                                                    <div class="form-option">
                                                        <div class="form-option-header">
                                                            <div class="form-option-title title-h4 font-weight-bold">Доставка СДЭКом <img loading="lazy" src="images/logo/logo-cdek.png" width="96" height="25" alt="СДЭК"></div>
                                                            <div class="form-option-subtitle">Укажите адрес доставки. Если не хотите заполнять, менеджер позвонит вам и заполнит вместе с вами</div>
                                                        </div>

                                                        <div class="form-option-content">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Город *" required >
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5 col-md-3 col-xxl-4">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Улица *" required >
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-2 col-md-2">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Дом *" required >
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5 col-md-3 col-xxl-2">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Квартира (офис) *" required >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <p class="checkout-delivery-price font-weight-bold" >Стоимость доставки 1&nbsp;500&nbsp;<span class="rouble" ></span></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <div class="form-option-header">
                                                            <div class="form-option-title title-h4 font-weight-bold">Доставка курьером по Москве и области</div>
                                                            <div class="form-option-subtitle">Укажите адрес доставки. Если не хотите заполнять, менеджер позвонит вам и заполнит вместе с вами</div>
                                                        </div>

                                                        <div class="form-option-content">
                                                            <div class="row">
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Город *" required >
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5 col-md-3 col-xxl-4">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Улица *" required >
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-2 col-md-2">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Дом *" required >
                                                                    </div>
                                                                </div>

                                                                <div class="col-sm-5 col-md-3 col-xxl-2">
                                                                    <div class="form-group">
                                                                        <input type="text" class="form-control" placeholder="Квартира (офис) *" required >
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <p class="checkout-delivery-price" ><b>Стоимость доставки 1 500 Р</b></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <div class="form-option-header">
                                                            <div class="form-option-title title-h4 font-weight-bold">Самовывоз из магазина в Москве</div>
                                                            <div class="form-option-subtitle">Мы находимся в г. Москва, Каширское шоссе, 61/3А, ТЦ СтройМолл <br> <b class="text-lead" >Заказ можно забрать 17 июля 2021 с 10:00 до 21:00</b></div>
                                                        </div>

                                                        <div class="form-option-content">
                                                            <div class="ckeckout-map-block">
                                                                <img src="uploads/maps/map-pick-up-image.jpg" alt="Карта самовывоза">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-option">
                                                        <div class="form-option-header">
                                                            <div class="form-option-title title-h4 font-weight-bold">Самовывоз СДЭК <img loading="lazy" src="images/logo/logo-cdek.png" width="96" height="25" alt="СДЭК"></div>
                                                        </div>

                                                        <div class="form-option-content">
                                                            <div class="ckeckout-map-block">
                                                                <img src="uploads/maps/map-cdek-image.png" alt="Карта СДЭК">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="checkout-controls">
                                                <div class="row align-items-center">
                                                    <div class="col-md-auto">
                                                        <div class="form-row flex-column flex-md-row">
                                                            <div class="col-md-auto">
                                                                <button type="button" class="checkout-control checkout-control-next btn btn-lg" >Перейти к следующему шагу</button>
                                                            </div>

                                                            <div class="col-md-auto">
                                                                <button type="button" class="checkout-control checkout-control-back btn btn-lg btn-secondary" >Назад</button>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md">
                                                        <div class="cart-fast-order-block">
                                                            <button type="button" class="cart-fast-order-link btn btn-link" data-toggle="modal" data-target="#modalQuickOrder" >Быстрый заказ</button>
                                                            <div class="cart-fast-order-hint">Менеджер уточнит всю информацию по телефону</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="checkout-group">
                                            <div class="checkout-headline d-lg-none">
                                                <button class="checkout-nav-link d-flex align-items-center collapsed" type="button" data-toggle="collapse"
                                                        data-target="#checkout-payment-collapse" aria-expanded="false" aria-controls="checkout-payment-collapse">
                                                    <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">3</span>
                                                    Оплата
                                                </button>
                                            </div>

                                            <div id="checkout-payment-collapse" class="checkout-collapse collapse" data-parent="#checkout-accordion">
                                                <div class="checkout-alert title-h3 text-danger font-weight-bold"><span class="form-hint-media">!</span> Стоимость дополнительных услуг может быть рассчитана только после общения с вами по whatsapp или
                                                    по телефону. Поэтому мы предлагаем вам оплатить свой заказ на сайте, а за услуги рассчитаться по факту</div>

                                                <div class="checkout-content">
                                                    <div class="form-options-group">
                                                        <div class="form-option">
                                                            <div class="form-option-header">
                                                                <div class="form-option-title title-h4 font-weight-bold">Картой онлайн</div>
                                                            </div>

                                                            <div class="form-option-content">
                                                                <p>После подтверждения заказа на следующем шаге, вы будете перенаправлены на платформу онлайн-платежей. Если вы не можете оплатить прямо сейчас, вам на почту вместе подтверждением заказа будет отправлена ссылка для оплаты</p>
                                                                <p><img src="images/logo/logo-payments-systems.png" width="331" height="50" alt="Платежные системы"></p>
                                                            </div>
                                                        </div>

                                                        <div class="form-option">
                                                            <div class="form-option-header">
                                                                <div class="form-option-title title-h4 font-weight-bold">Наличными или картой при получении (только при самовывозе из магазина)</div>
                                                            </div>
                                                        </div>

                                                        <div class="form-option">
                                                            <div class="form-option-header">
                                                                <div class="form-option-title title-h4 font-weight-bold">По счету от юридического лица</div>
                                                            </div>

                                                            <div class="form-option-content">
                                                                <p>Данный способ доступен для оплаты только от имени юридических лиц, платежи от физлиц будут возвращены. <br> <b class="text-lead" >Вам будет выставлен счет на оплату в соответствии с реквизитами</b></p>

                                                                <div class="custom-file">
                                                                    <input type="text" id="checkout-attached-files" class="custom-file-input">
                                                                    <label for="checkout-attached-files" class="custom-file-label">
                                                                        <svg class="custom-file-media" width="24" height="26">
                                                                            <use xlink:href="/images/sprite.svg#icon-attach"></use>
                                                                        </svg>
                                                                        Прикрепить файл <span class="text-muted" >(принимаются файлы в формате jpg, pdf, doc и xls)</span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="checkout-controls">
                                                    <div class="row align-items-center">
                                                        <div class="col-md-auto">
                                                            <div class="form-row flex-column flex-md-row">
                                                                <div class="col-md-auto">
                                                                    <button type="button" class="checkout-control checkout-control-next btn btn-lg" >Подтвердить и оплатить</button>
                                                                </div>

                                                                <div class="col-md-auto">
                                                                    <button type="button" class="checkout-control checkout-control-back btn btn-lg btn-secondary" >Назад</button>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md">
                                                            <div class="cart-fast-order-block">
                                                                <button type="button" class="cart-fast-order-link btn btn-link" data-toggle="modal" data-target="#modalQuickOrder" >Быстрый заказ</button>
                                                                <div class="cart-fast-order-hint">Менеджер уточнит всю информацию по телефону</div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="checkout-group">
                                            <div class="checkout-headline d-lg-none">
                                                <button class="checkout-nav-link d-flex align-items-center collapsed" type="button" data-toggle="collapse"
                                                        data-target="#checkout-confirm-collapse" aria-expanded="false" aria-controls="checkout-confirm-collapse">
                                                    <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">4</span>
                                                    Подтверждение заказа
                                                </button>
                                            </div>

                                            <div id="checkout-confirm-collapse" class="checkout-collapse collapse" data-parent="#checkout-accordion">
                                                <div class="checkout-content">
                                                    Подтверждение заказа
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
