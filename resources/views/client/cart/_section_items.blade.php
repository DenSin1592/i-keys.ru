<section class="section-cart section-gray">
    <div class="container">
        <div class="order-list">

            @foreach($itemListData['items'] as $itemKey => $item)
                @include('client.cart._order_item')
            @endforeach

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
