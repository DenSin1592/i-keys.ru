{{-- Control block in the list --}}

<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.product-type-pages.edit', $productTypePage->id) }}"></a>
<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную страницу типа товаров?"
   href="{{ route('cc.product-type-pages.destroy', [$productTypePage->id]) }}"></a>
