<div class="top-padding">
    <div class="categories-list">
        <ul class="nav nav-tabs available-products-tabs" role="tablist">
            @foreach ($groupedProducts as $groupIndex => $group)
                <li role="presentation" class="{{ $groupIndex === 0 ? 'active' : '' }}">
                    <a href="#available_products_tab_{{ \Helper::replaceSquareBrackets($fieldGroup, '_') }}_{{ $groupIndex }}"
                       aria-controls="home" role="tab" data-toggle="tab">
                        <span>{{ $group['category']->name }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="form-group has-feedback">
        <input class="form-control" placeholder="Фильтр" type="text"
               data-associated-products="filter-available"
               data-filter-url="{{ route('cc.associated-products.filter-available', isset($productId) ? $productId : null) }}"
               data-product-list-filter="#available_products_tab_content_{{ \Helper::replaceSquareBrackets($fieldGroup, '_') }}" />
        <span class="glyphicon glyphicon-search form-control-feedback apply-filter-button btn" aria-hidden="true" data-associated-products="apply-filter" data-target="[data-associated-products='filter-available']"></span>
    </div>
</div>

<div class="tab-content" id="available_products_tab_content_{{ \Helper::replaceSquareBrackets($fieldGroup, '_') }}">
    @foreach ($groupedProducts as $groupIndex => $group)
        <div role="tabpanel" class="tab-pane {{ $groupIndex === 0 ? 'active' : '' }}"
             id="available_products_tab_{{ \Helper::replaceSquareBrackets($fieldGroup, '_') }}_{{ $groupIndex }}"
             data-category-id="{!! $group['category']->id !!}">
            @include('admin.shared.popup_associated_products._available_product_list', ['products' => $group['products']])
        </div>
    @endforeach
</div>
