<ul>
    @foreach ($categoryTree as $category)
        <li class="category">
            @if (count($category->children) > 0)
                <span class="toggleable" @if (count($category->products)) data-action="get-products" data-item-type="catalog-category" data-url="{{ route('cc.orders.items.products.list', [$category->id]) }}" data-method="get" @endif>{{ $category->name }}</span>

                <div class="category-content loaded">
                    @include('admin.orders.form.order_items._popup._left_menu._category_tree', ['categoryTree' => $category->children])
                </div>

            @else
                <label class="toggleable" data-action="get-products" data-item-type="catalog-category" data-url="{{ route('cc.orders.items.products.list', [$category->id]) }}" data-method="get">
                    {{ $category->name }}
                </label>
            @endif

        </li>
    @endforeach
</ul>
