@if ($order->can_be_paid_by_card)
<fieldset class="bordered-group form-group send-link-container">
    <legend>Ссылка на оплату в ПСБ</legend>
    <div style="padding-bottom: 10px;">
        <span>
            Ссылка:
            <a target="_blank" href="{{ route('psbank.order', [$order->id]) }}">{{ route('psbank.order', [$order->id]) }}</a>
        </span>
        <div class="send-link">
            @if(!empty($order->email))
            <a data-action="orders.send-psbank-payment-link"
               data-url="{{ route('cc.orders.send-psbank-payment-link', [$order->id]) }}"
               data-method="get"
               href="javascript:void(0);">Отправить ссылку на оплату в ПСБ клиенту</a>
            <span class="ajax-loader"><img src="{{ \Asset::timed('/images/common/ajax-loader/small_black.gif') }}"></span>
            @else
                <div class="field-hint-block hint-red">
                    Отправить ссылку на оплату клиенту можно только у заказов с заполненным полем Email.
                </div>
            @endif
        </div>
    </div>
</fieldset>
@endif