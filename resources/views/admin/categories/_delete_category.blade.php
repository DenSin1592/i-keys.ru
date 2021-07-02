{{-- Buttton to delete category --}}

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную категорию?"
   href="{{ route('cc.categories.destroy', $category->id) }}">{{ trans('interactions.delete') }}</a>
