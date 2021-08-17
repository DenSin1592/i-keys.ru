@if (old('manual_products_opened'))
    <div class="products-tree-wrapper">
        <label class="control-label">Каталог</label>
        <div class="products-tree-container catalog-tree element-list-wrapper">
            @include('admin.product_type_pages.products._manual_root', ['categories' => $manualData['categories']])
        </div>
    </div>
@else
    <a class="show-products-tree btn btn-default"
       href="javascript:void(0);"
       data-action-url="{{ route('cc.product-type-pages.products.manual-tree', $productTypePage->id) }}"
       data-action-method="get">Показать блок "Каталог"</a>
    <div class="products-tree-wrapper" style="display: none;">
        <label class="control-label">Каталог</label>

        <div class="products-tree-container catalog-tree element-list-wrapper">
            <img src="{{ Asset::timed('/images/common/ajax-loader/small_black.gif') }}"/>
        </div>
    </div>
@endif
