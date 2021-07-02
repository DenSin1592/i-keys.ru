<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.admin-users.edit', [$user->id]) }}"></a>

@if (Auth::user()->id == $user->id)
    <span class="glyphicon glyphicon-trash" title="{{ trans('alerts.delete_is_disallowed') }}"></span>
@else
    <a class="glyphicon glyphicon-trash"
       title="{{ trans('interactions.delete') }}"
       data-method="delete"
       data-confirm="Вы уверены, что хотите удалить данного администратора?"
       href="{{ route('cc.admin-users.destroy', [$user->id]) }}"></a>
@endif
