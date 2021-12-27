{{-- Control block for exact type in the list --}}

<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.products-series.edit', $model->id) }}"></a>
<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную модель?"
   href="{{ route('cc.products-series.destroy', [$model->id]) }}"></a>
