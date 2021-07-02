{{-- Buttton to delete category --}}

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный тип?"
   href="{{ route('cc.types.destroy', $type->id) }}">{{ trans('interactions.delete') }}</a>
