<input type="hidden" name="filtered_products_opened" value="1" />
@if (count($filteredData['products']) > 0)
    <ol class="product-type-page-products">
        @foreach ($filteredData['products'] as $product)
            <li>
                <span class="product-name"
                      data-product-association-url="{{ route('cc.product-type-pages.products.association-block', [$product->id, 'filtered', $productTypePage->id]) }}">{{ $product->name }}</span>

                @if (\Arr::get($filteredData['associations'], $product->id))
                    @include('admin.product_type_pages.products._association_block', ['association' => \Arr::get($filteredData['associations'], $product->id), 'associationType' => 'filtered', 'associationOpened' => true])
                @endif
            </li>
        @endforeach
    </ol>
@else
    <i>Не найдено ни одного товара</i>
@endif