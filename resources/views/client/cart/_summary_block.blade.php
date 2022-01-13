<div class="display-subtitle title-h4" id="summary-container">
    В корзине {!! \Cart::summaryCount() . ' ' . \Lang::choice('товар|товара|товаров', \Cart::summaryCount()) . ','!!}

    @if($countServices = \Cart::getTotalServicesCount())
    {!! $countServices . ' ' . \Lang::choice('услуга|услуги|услуг', $countServices) . ','!!}
    @endif

    на сумму {!! Helper::priceFormat(\Cart::totalPrice()) !!}  р.
</div>
