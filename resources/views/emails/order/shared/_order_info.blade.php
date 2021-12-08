<p>Состав заказа:</p>
<div id="order-items-complete-table" style="margin: 0;">
@include('emails.order.shared._order_items', ['order' => $order])
</div>

<p>Данные заказа:</p>
@include('emails.shared._data_table', ['data' => $orderData])