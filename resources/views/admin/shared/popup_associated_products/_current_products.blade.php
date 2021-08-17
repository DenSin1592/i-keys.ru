<ol>
    @foreach ($associatedProducts as $associatedProductKey => $associatedProduct)
        <li data-associated-products="current-product-element"
            data-product-name="{{ $associatedProduct['product']->name }}">
            <input data-product-element="product_id" type="hidden" name="{{ "{$fieldGroup}[{$associatedProductKey}][product_id]" }}" value="{{ $associatedProduct['product']->id }}" />
            @if (empty($disableSorting))
                <input data-product-element="position" type="hidden" name="{{ "{$fieldGroup}[{$associatedProductKey}][position]" }}" value="{{ $associatedProduct['position'] }}" />
            @endif
            <a href="{{ route('cc.products.edit', [$associatedProduct['product']->category_id, $associatedProduct['product']->id]) }}" target="_blank">
                {!! $associatedProduct['product']->name_with_code_1c !!}
            </a>

            @foreach (['product_id'] as $field)
                @foreach ($errors->get(\Helper::replaceSquareBrackets($fieldGroup, '.') . ".{$associatedProductKey}.$field") as $fieldError)
                    <div class="text-danger">{{ $fieldError }}</div>
                @endforeach
            @endforeach
        </li>
    @endforeach
</ol>