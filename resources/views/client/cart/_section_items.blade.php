<section class="section-cart section-gray">
    <div class="container">
        <div class="row">
            <div class="cart-order-list-container col-xl-10">
                <div class="order-list">

                    @foreach($itemListData['items'] as $itemKey => $item)
                        @include('client.cart._order_item')
                    @endforeach

                </div>
            </div>

            <div class="cart-controls-container col-xl-2">
                <div class="cart-controls">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-auto col-xl-12 mb-2 mb-md-0 mb-xl-1 mb-xxl-2">
                            <div class="row justify-content-between flex-md-column flex-xl-row">
                                <div class="col-auto">
                                    <div class="title-h3">Итого:</div>
                                </div>

                                <div class="col-auto">
                                    <div class="title-h3 font-weight-bold">{!! Helper::priceFormat(\Cart::totalPrice()) !!}<span class="rouble" >руб.</span></div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-auto col-xl-12 d-flex flex-column flex-md-row">
                            <button type="button" class="cart-control cart-control-confirm btn btn-lg">Оформить заказ</button>
                        </div>

                        <div class="col-md col-xl-12">
                            <div class="cart-fast-order-block">
                                <button type="button" class="cart-fast-order-link btn btn-link" data-toggle="modal" data-target="#modalQuickOrder" >Быстрый заказ</button>
                                <div class="cart-fast-order-hint">Менеджер уточнит всю информацию по телефону</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
