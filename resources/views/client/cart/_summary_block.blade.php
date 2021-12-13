<div class="display-subtitle title-h4" id="summary-container">
    В корзине {!!   Helper::priceFormat(\Cart::summaryCount()) . ' ' . \Lang::choice('товар|товара|товаров', \Cart::summaryCount()) !!}
    ,{{-- 2 услуги--}}
    на сумму {!! Helper::priceFormat(\Cart::totalPrice()) !!}  р.
</div>
