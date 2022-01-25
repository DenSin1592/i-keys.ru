
{!! $topContent !!}

{!! $linksTypesContent ?? '' !!}

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

