<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.orders.edit', [$order->id]) }}"></a>

<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить заказ?"
   href="{{ route('cc.orders.destroy', [$order->id]) }}"></a>
