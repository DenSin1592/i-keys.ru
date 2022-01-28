<section class="section-checkout">
    <div class="container">
        <div class="checkout-header">
            <div class="checkout-title title-h3 text-uppercase">Оформление заказа</div>
{{--                    <div class="checkout-subtitle title-h4 font-weight-bold">Вы заказали 12 товаров на сумму 2 500 р и 2 услуги</div>--}}
                @include('client.cart._summary_block')
        </div>

        <div class="checkout-accordion" id="checkout-accordion">
            <div class="form-checkout" id="order-form">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="checkout-nav-list d-flex flex-lg-column justify-content-center">
                            <button class="checkout-nav-link d-flex align-items-center flex-column flex-lg-row" data-order-step="1" type="button" data-toggle="collapse"
                                    data-target="#checkout-information-collapse" aria-expanded="true" aria-controls="checkout-information-collapse">
                                <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">1</span>
                                <span class="d-none d-sm-block text-center text-lg-left">Личная информация</span>
                            </button>

                            <div class="checkout-nav-delimiter d-flex d-lg-none"></div>

                            <button class="checkout-nav-link d-flex align-items-center flex-column flex-lg-row collapsed" data-order-step="2" type="button" disabled data-toggle="collapse"
                                    data-target="#checkout-delivery-collapse" aria-expanded="false" aria-controls="checkout-delivery-collapse">
                                <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">2</span>
                                <span class="d-none d-sm-block text-center text-lg-left">Доставка</span>
                            </button >

                            <div class="checkout-nav-delimiter d-flex d-lg-none"></div>

                            <button class="checkout-nav-link d-flex align-items-center flex-column flex-lg-row collapsed" data-order-step="3" type="button" disabled data-toggle="collapse"
                                    data-target="#checkout-payment-collapse" aria-expanded="false" aria-controls="checkout-payment-collapse">
                                <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">3</span>
                                <span class="d-none d-sm-block text-center text-lg-left">Оплата</span>
                            </button>

                            <div class="checkout-nav-delimiter d-flex d-lg-none"></div>

                            <button class="checkout-nav-link d-flex align-items-center flex-column flex-lg-row collapsed" data-order-step="4" type="button" disabled data-toggle="collapse"
                                    data-target="#checkout-confirm-collapse" aria-expanded="false" aria-controls="checkout-confirm-collapse">
                                <span class="checkout-nav-count d-inline-flex align-items-center justify-content-center">4</span>
                                <span class="d-none d-sm-block text-center text-lg-left">Подтверждение заказа</span>
                            </button>
                        </div>
                    </div>

                    <div class="col-lg-9 mt-4 mt-lg-0">
                        <div data-step="1" class="checkout-group">
                            <div id="checkout-information-collapse" class="checkout-collapse collapse show" data-parent="#checkout-accordion">
                                <form action="#step-1" method="post" enctype="multipart/form-data" >
                                    <div class="checkout-content">
                                        <div class="form-group">
                                            <input name="name" type="text" class="form-control" placeholder="Имя" id="checkout-user-name">
                                        </div>

                                        <div class="form-group">
                                            <input name="phone" type="tel" class="form-control" placeholder="Телефон *" id="checkout-user-phone" required data-client-phone-mask>
                                        </div>

                                        <div class="form-group">
                                            <input name="email" type="email" class="form-control" placeholder="Почта *" id="checkout-user-email" required>
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
                                </form>
                            </div>
                        </div>
                        <div data-step="2" class="checkout-group">
                            <div id="checkout-delivery-collapse" class="collapse" data-parent="#checkout-accordion">
                                <form action="#step-2" method="post" enctype="multipart/form-data" >
                                    <div class="checkout-content">
                                        <div class="form-options-group">
                                            <div class="form-option input-group">
                                                <input type="radio" class="form-option-radio" name="delivery_method" value="{{ \App\Models\Order::DELIVERY_CDEK }}" autocomplete="off" hidden required>
                                                <div class="form-option-header">
                                                    <div class="form-option-title title-h4 font-weight-bold">Доставка СДЭКом <img loading="lazy" src="images/logo/logo-cdek.png" width="96" height="25" alt="СДЭК"></div>
                                                    <div class="form-option-subtitle">Укажите адрес доставки. Если не хотите заполнять, менеджер позвонит вам и заполнит вместе с вами</div>
                                                </div>

                                                <div class="form-option-content w-100">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input name="city*{{ \App\Models\Order::DELIVERY_CDEK }}" type="text" class="form-control" placeholder="Город *" data-option-required disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-5 col-md-3 col-xxl-4">
                                                            <div class="form-group">
                                                                <input name="street*{{ \App\Models\Order::DELIVERY_CDEK }}" type="text" class="form-control" placeholder="Улица *"  data-option-required disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <input name="building*{{ \App\Models\Order::DELIVERY_CDEK }}" type="text" class="form-control" placeholder="Дом *" data-option-required disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-5 col-md-3 col-xxl-2">
                                                            <div class="form-group">
                                                                <input name="flat*{{ \App\Models\Order::DELIVERY_CDEK }}" type="text" class="form-control" placeholder="Квартира (офис) *" data-option-required disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p class="checkout-delivery-price font-weight-bold" >Стоимость доставки 1&nbsp;500&nbsp;<span class="rouble" ></span></p>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <input type="radio" class="form-option-radio" name="delivery_method" value="{{ \App\Models\Order::DELIVERY_COURIER }}" autocomplete="off" hidden required>
                                                <div class="form-option-header" id="checkout-delivery-courier" name="{{ \App\Models\Order::DELIVERY_COURIER }}" >
                                                    <div class="form-option-title title-h4 font-weight-bold">Доставка курьером по Москве и области</div>
                                                    <div class="form-option-subtitle">Укажите адрес доставки. Если не хотите заполнять, менеджер позвонит вам и заполнит вместе с вами</div>
                                                </div>

                                                <div class="form-option-content">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <input name="city*{{ \App\Models\Order::DELIVERY_COURIER }}" type="text" id="checkout-addres-city" class="form-control" placeholder="Город *" data-option-required disabled >
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-5 col-md-3 col-xxl-4">
                                                            <div class="form-group">
                                                                <input name="street*{{ \App\Models\Order::DELIVERY_COURIER }}" id="checkout-address-street" type="text" class="form-control" placeholder="Улица *" data-option-required disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-2 col-md-2">
                                                            <div class="form-group">
                                                                <input name="building*{{ \App\Models\Order::DELIVERY_COURIER }}" id="checkout-address-house" type="text" class="form-control" placeholder="Дом *" data-option-required disabled>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-5 col-md-3 col-xxl-2">
                                                            <div class="form-group">
                                                                <input name="flat*{{ \App\Models\Order::DELIVERY_COURIER }}" id="checkout-address-apartment" type="text" class="form-control" placeholder="Квартира (офис) *"  data-option-required disabled>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <p class="checkout-delivery-price" ><b>Стоимость доставки 1 500 Р</b></p>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <input type="radio" class="form-option-radio" name="delivery_method" value="{{ \App\Models\Order::DELIVERY_SELF }}" autocomplete="off" hidden required>
                                                <div class="form-option-header" id="checkout-delivery-self" name="{{ \App\Models\Order::DELIVERY_SELF }}">
                                                    <div class="form-option-title title-h4 font-weight-bold">Самовывоз из магазина в Москве</div>
                                                    <div class="form-option-subtitle">Мы находимся в г. Москва, Каширское шоссе, 61/3А, ТЦ СтройМолл <br> <b class="text-lead" >Заказ можно забрать с 10:00 до 21:00</b></div>
                                                </div>

                                                <div class="form-option-content">
                                                    <div class="ckeckout-map-block">
                                                        <div id="forpvz" style="height:600px;"></div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <input type="radio" class="form-option-radio" name="delivery_method" value="{{ \App\Models\Order::DELIVERY_SELF_CDEK }}" autocomplete="off" hidden required>
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
                                </form>
                            </div>
                        </div>
                        <div data-step="3" class="checkout-group">
                            <div id="checkout-payment-collapse" class="checkout-collapse collapse" data-parent="#checkout-accordion">
                                <div class="checkout-alert title-h3 text-danger font-weight-bold">
                                    <span class="form-hint-media">!</span>
                                    Стоимость дополнительных услуг может быть рассчитана только после общения с вами по whatsapp или
                                    по телефону. Поэтому мы предлагаем вам оплатить свой заказ на сайте, а за услуги рассчитаться по факту
                                </div>

                                <form action="{{route('order.store')}}" method="post" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="checkout-content">
                                        <div class="form-options-group">
                                            <div class="form-option">
                                                <input type="radio" class="form-option-radio" name="payment_method" value="{{ \App\Models\Order::PAYMENT_ONLINE }}" autocomplete="off" hidden required>
                                                <div class="form-option-header" id="checkout-payment-online" name="{{ \App\Models\Order::PAYMENT_ONLINE }}">
                                                    <div class="form-option-title title-h4 font-weight-bold">Картой онлайн</div>
                                                </div>

                                                <div class="form-option-content">
                                                    <p>
                                                        После подтверждения заказа на следующем шаге, вы будете перенаправлены на платформу онлайн-платежей.
                                                        Если вы не можете оплатить прямо сейчас, вам на почту вместе подтверждением заказа будет отправлена ссылка для оплаты
                                                    </p>
                                                    <p><img src="images/logo/logo-payments-systems.png" width="331" height="50" alt="Платежные системы"></p>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <input type="radio" class="form-option-radio" name="payment_method" value="{{ \App\Models\Order::PAYMENT_CASH }}" autocomplete="off" hidden required>
                                                <div class="form-option-header" id="checkout-payment-cash" name="{{ \App\Models\Order::PAYMENT_CASH }}">
                                                    <div class="form-option-title title-h4 font-weight-bold">
                                                        Наличными или картой при получении (только при самовывозе из магазина)
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-option">
                                                <input type="radio" class="form-option-radio" name="payment_method" value="{{ \App\Models\Order::PAYMENT_INVOICE }}" autocomplete="off" hidden required>
                                                <div class="form-option-header" id="checkout-payment-invoice" name="{{ \App\Models\Order::PAYMENT_INVOICE }}">
                                                    <div class="form-option-title title-h4 font-weight-bold">По счету от юридического лица</div>
                                                </div>

                                                <div class="form-option-content">
                                                    <p>
                                                        Данный способ доступен для оплаты только от имени юридических лиц, платежи от физлиц будут возвращены. <br>
                                                        <b class="text-lead" >Вам будет выставлен счет на оплату в соответствии с реквизитами</b>
                                                    </p>

                                                    <div class="custom-file">
                                                        <input type="file" size="20971520" name="file_upload" id="checkout-attached-files" class="custom-file-input form-control" disabled>

                                                        <label for="checkout-attached-files" class="custom-file-label">
                                                            <svg class="custom-file-media" width="24" height="26">
                                                                <use xlink:href="/images/sprite.svg#icon-attach"></use>
                                                            </svg>
                                                            Прикрепить файл <span class="text-muted" >(принимаются файлы в формате jpg, pdf, doc и xls)</span>
                                                        </label>
                                                        <div class="invalid-feedback type">Неверное расширение файла</div>
                                                        <div class="invalid-feedback size"></div>
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
                                                        <button type="submit" class="checkout-control checkout-control-next btn btn-lg" >Подтвердить и оплатить</button>
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
                                </form>
                            </div>
                        </div>
                        <div data-step="4" class="checkout-group">
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
</section>



