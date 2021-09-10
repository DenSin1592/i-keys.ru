@foreach ($orderItems as $orderItem)
    @include('admin.orders.form.order_items._order_item')
    @if ($errors->has("order_items.{$orderItem->id}"))
        <tr class="validation-errors">
            <td colspan="10">
                @foreach ($errors->get("order_items.{$orderItem->id}") as $errorMessage)
                    {{ $errorMessage }}<br/>
                @endforeach
            </td>
        </tr>
    @endif
@endforeach
<tr class="empty"></tr>
