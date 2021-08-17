{{-- Control block for exact category in the list --}}

<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.categories.edit', $category->id) }}"></a>
<a class="glyphicon glyphicon-align-justify"
   title="Список товаров"
   href="{{ route('cc.products.index', $category->id) }}"></a>
<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную категорию?"
   href="{{ route('cc.categories.destroy', [$category->id]) }}"></a>
