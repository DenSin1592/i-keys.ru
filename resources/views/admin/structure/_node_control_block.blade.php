{{-- Control block for exact node in list --}}

<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ TypeContainer::getContentUrl($node) }}"></a>
<a class="glyphicon glyphicon-wrench"
   title="{{ trans('interactions.properties') }}"
   href="{{ route('cc.structure.edit', [$node->id]) }}"></a>
<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данную страницу?"
   href="{{ route('cc.structure.destroy', [$node->id]) }}"></a>
