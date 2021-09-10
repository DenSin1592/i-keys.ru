{{-- Buttton to delete order --}}

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный заказ?"
   href="{{ route('cc.orders.destroy', $order->id) }}">{{ trans('interactions.delete') }}</a>
