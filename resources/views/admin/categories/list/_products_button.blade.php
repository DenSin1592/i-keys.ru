<a href="{{ route('cc.products.index', [$category->id]) }}" class="btn btn-default btn-xs products">
    Товары{{--
    --}}@if ($category->total_products_count){{--
        --}}: {{--
        --}}<span class="count" title="Количество товаров в категории">{{ $category->child_products_count }}</span>{{--
        --}} / {{--
        --}}<span class="count" title="Общее количество товаров, включая товары во всех вложенных категориях">{{ $category->total_products_count }}</span>{{--
    --}}@endif
</a>
