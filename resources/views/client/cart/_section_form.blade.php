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