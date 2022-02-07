@foreach($associatedProducts as $key => $associatedProductsGroups)
    <fieldset class="bordered-group">
        <legend>{{__('categories.' . $key)}}</legend>

        <ol>
            @foreach ($associatedProductsGroups as $associatedProductKey => $associatedProduct)
                <li data-associated-products="current-product-element"
                    data-product-name="{{ $associatedProduct['product']->name }}">
                    <input data-product-element="product_id" type="hidden"
                           name="{{ "{$fieldGroup}[".$associatedProductKey+$loop->parent->index."][product_id]" }}"
                           value="{{ $associatedProduct['product']->id }}"/>
                    @if (empty($disableSorting))
                        <input data-product-element="position" type="hidden"
                               name="{{ "{$fieldGroup}[".$associatedProductKey+$loop->parent->index."][position]" }}"
                               value="{{ $associatedProduct['position'] }}"/>
                    @endif
                    <a href="{{ route('cc.products.edit', [$associatedProduct['product']->category_id, $associatedProduct['product']->id]) }}"
                       target="_blank">
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
    </fieldset>
@endforeach
