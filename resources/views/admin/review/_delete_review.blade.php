{{-- Buttton to delete order --}}

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный отзыв?"
   href="{{ route('cc.reviews.destroy', $review->id) }}">{{ trans('interactions.delete') }}</a>
