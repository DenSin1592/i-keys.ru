{!! Form::tbFormGroupOpen('product_id') !!}
{!! Form::tbLabel('product_id', 'Товар') !!}

<div class="field-hint-block">Для поиска товара введите его название</div>
{!! Form::tbSelect('product_id', $productVariants, null, [
    'data-review-products-search-url' => route('cc.reviews.get-searched-review-product-values'),
]) !!}

@include('admin.review._product_links')

{!! Form::tbFormGroupClose() !!}
