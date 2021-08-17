@if (count($category->children) > 0)
    @include('admin.product_type_pages.products._manual_category_tree', ['categories' => $category->children])
@endif

@if (count(($products = $manualData['products_group_by_categories']->get($category->id, []))) > 0)
    <ul class="product-type-page-products">
        @foreach ($products as $product)
            <li class="product-manual">
                {!! Form::checkbox("manual_products[]", $product->id, in_array($product->id, $manualData['product_ids'])) !!}

                <span class="product-name"
                      data-product-association-url="{{ route('cc.product-type-pages.products.association-block', [$product->id, 'manual', $productTypePage->id]) }}">{{ $product->name }}</span>

                @if (\Arr::get($manualData['associations'], $product->id))
                    @include('admin.product_type_pages.products._association_block', ['association' => \Arr::get($manualData['associations'], $product->id), 'associationType' => 'manual', 'associationOpened' => true])
                @endif
            </li>
        @endforeach
    </ul>
@endif
