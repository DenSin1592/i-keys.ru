<ul>
    @foreach ($categories as $category)
        <li class="category">
            <input type="checkbox" class="category-select" />
            <span class="category-toggle"
                  data-url="{{ route('cc.product-type-pages.products.manual-subtree', [$category->id, $productTypePage->id]) }}"
                  data-method="get">
                {{ $category->name }}
            </span>
            <span class="loader glyphicon"></span>

            <div class="category-content {{ in_array($category->id, $manualData['active_categories_ids']) ? 'loaded visible' : ''}}">
                @if (in_array($category->id, $manualData['active_categories_ids']))
                    @include('admin.product_type_pages.products._manual_category_sub_tree', ['category' => $category])
                @endif
            </div>
        </li>
    @endforeach
</ul>
