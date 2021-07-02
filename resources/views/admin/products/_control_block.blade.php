{{-- Control block for exact product in the list --}}

<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.products.edit', [$product->category->id, $product->id]) }}"></a>
<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный товар?"
   href="{{ route('cc.products.destroy', [$product->category->id, $product->id]) }}"></a>
