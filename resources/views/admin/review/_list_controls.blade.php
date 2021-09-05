<a class="glyphicon glyphicon-pencil"
   title="{{ trans('interactions.edit') }}"
   href="{{ route('cc.reviews.edit', [$review->id]) }}"></a>

<a class="glyphicon glyphicon-trash"
   title="{{ trans('interactions.delete') }}"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить отзыв?"
   href="{{ route('cc.reviews.destroy', [$review->id]) }}"></a>
