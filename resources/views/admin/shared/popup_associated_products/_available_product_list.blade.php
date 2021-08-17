<ul class="product-list">
    @foreach ($products as $product)
        <li class="product-list-element {{ in_array($product->id, $selectedProductIds) ? 'selected' : null }}"
            data-associated-products="product-element"
            data-product-name="{{ $product->name_with_code_1c }}" data-product-id="{{ $product->id }}">
                        <span class="product-control selected-hidden glyphicon glyphicon-plus text-success"
                              data-associated-products="add"></span>
            <span>
            {!! $product->name_with_code_1c !!}
            </span>
        </li>
    @endforeach
</ul>