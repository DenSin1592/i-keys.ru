{!! $linksTypesContent ?? '' !!}

<div class="catalog-subcategories-grid row">
    <div class="catalog-subcategory-item col-6 col-sm-3">
        <a href="#link" class="card-subcategory d-block">
            <span class="card-subcategory-thumbnail d-flex align-items-center justify-content-center">
                <img loading="lazy" src="{{asset('images/client/subcategories/icon-subcategory-cylinder.svg')}}" width="128" height="135" alt="Цилиндры" class="card-subcategory-media">
            </span>

            <span class="card-subcategory-title">Цилиндры</span>
        </a>
    </div>

    <div class="catalog-subcategory-item col-6 col-sm-3">
        <a href="#link" class="card-subcategory d-block">
            <span class="card-subcategory-thumbnail d-flex align-items-center justify-content-center">
                <img loading="lazy" src="{{asset('images/client/subcategories/icon-subcategory-padlock.svg')}}" width="91" height="133" alt="Навесные замки" class="card-subcategory-media">
            </span>

            <span class="card-subcategory-title">Навесные замки</span>
        </a>
    </div>

    <div class="catalog-subcategory-item col-6 col-sm-3">
        <a href="#link" class="card-subcategory d-block">
            <span class="card-subcategory-thumbnail d-flex align-items-center justify-content-center">
                <img loading="lazy" src="{{asset('images/client/subcategories/icon-subcategory-morticelock.svg')}}" width="116" height="164" alt="Врезные замки" class="card-subcategory-media">
            </span>

            <span class="card-subcategory-title">Врезные замки</span>
        </a>
    </div>

    <div class="catalog-subcategory-item col-6 col-sm-3">
        <a href="#link" class="card-subcategory d-block">
            <span class="card-subcategory-thumbnail d-flex align-items-center justify-content-center">
                <img loading="lazy" src="{{asset('images/client/subcategories/icon-subcategory-overhead.svg')}}" width="209" height="122" alt="Накладные замки" class="card-subcategory-media">
            </span>

            <span class="card-subcategory-title">Накладные замки</span>
        </a>
    </div>
</div>

@if(!empty($filter['filterVariants']))
    @include('client.categories._selected_variants')
@endif

@include('client.categories._catalog_controls')


@if(\Arr::get($filter, 'currentFilterQuery.view') === \App\Models\Product::VIEW_LIST)
    {{--  @include('client.categories._products_list')--}}Товары списком
@else
    @include('client.categories._products_grid._catalog_list')
@endif

@if (count($productsData) === 0 && !empty($filter['filterVariants']))
    <div class="font-weight-bold">
        К сожалению, по выбранным Вами параметрам не найдено ни одного товара. <br>
        Попробуйте расширить критерии поиска или посмотреть весь <a
            href="{{ UrlBuilder::getUrl($category) }}">каталог</a>.
    </div>
@endif



{!! $paginator->onEachSide(1)->links('client.shared.pagination.client') !!}


@include('client.categories._content._bottom', ['model' => $category])

