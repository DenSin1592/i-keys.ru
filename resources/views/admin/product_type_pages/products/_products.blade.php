{!! Form::tbFormGroupOpen('product_list_way') !!}
{!! Form::tbLabel('product_list_way', trans('validation.attributes.product_list_way')) !!}
<div>
    @foreach (\App\Models\ProductTypePage::availableWays() as $way => $wayTitle)
        <label class="radio-inline">
            {!! Form::radio('product_list_way', $way, null, ['data-change-product-list-way' => "#products-way-{$way}", 'autocomplete' => 'off']) !!}
            {{ $wayTitle }}
        </label>
    @endforeach
</div>
{!! Form::tbFormGroupClose() !!}

<div id="products-way-{{ \App\Models\ProductTypePage::WAY_FILTERED }}"
     class="products-way-container {{ old('product_list_way', $productTypePage->product_list_way) == \App\Models\ProductTypePage::WAY_FILTERED ? 'active' : '' }}">
    <fieldset class="bordered-group">
        <legend>Товары по фильтру</legend>

        {!! Form::tbFormGroupOpen('filter_query') !!}
        {!! Form::tbLabel('filter_query', trans('validation.attributes.filter_query')) !!}
        {!! Form::tbText('filter_query', null, ['data-old-value' => Form::getValueAttribute('filter_query'), 'autocomplete' => 'off']) !!}
        {!! Form::tbFormGroupClose() !!}

        <div class="form-group">
            <div class="filtered-products-update-hint" id="filtered-products-update-hint">
                Условия фильтра были изменены, вам необходимо
                <a href="{{ route('cc.product-type-pages.products.filtered-products', [$productTypePage->id]) }}">обновить</a>
                список товаров.
            </div>

            <div>
                <strong @if (!old('filtered_products_opened', false)) class="show-filter-products" @endif >
                    Товары
                </strong>
                <div id="filtered-products-container">
                    @if (old('filtered_products_opened', false))
                    @include('admin.product_type_pages.products._filtered_products')
                    @endif
                </div>
            </div>
        </div>
    </fieldset>
</div>

<div id="products-way-{{ \App\Models\ProductTypePage::WAY_MANUAL }}"
     class="products-way-container {{ old('product_list_way', $productTypePage->product_list_way) == \App\Models\ProductTypePage::WAY_MANUAL ? 'active' : '' }}">
    <fieldset class="bordered-group">
        <legend>Вручную набранные товары</legend>

        <div class="form-group">
            @include('admin.product_type_pages.products._manual_products')
        </div>
    </fieldset>
</div>
