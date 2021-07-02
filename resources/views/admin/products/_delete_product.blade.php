{{-- Buttton to delete product --}}

<a class="btn btn-danger"
   data-method="delete"
   data-confirm="Вы уверены, что хотите удалить данный товар?"
   href="{{ route('cc.products.destroy', [$product->category->id, $product->id]) }}">{{ trans('interactions.delete') }}</a>
