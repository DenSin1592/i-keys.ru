{{-- Buttton to delete order --}}

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную серию?"
   href="{{ route('cc.products-series.destroy', $formData['model']->id) }}">{{ trans('interactions.delete') }}</a>
