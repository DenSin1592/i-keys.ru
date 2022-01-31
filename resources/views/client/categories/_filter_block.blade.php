<div class="filter-header d-none d-lg-block">
    <div class="filter-title title-h3 text-uppercase">
        <svg class="filter-title-media" width="33" height="30">
            <use xlink:href="{{asset('/images/client/sprite.svg#icon-filter')}}"></use>
        </svg>
        Фильтр
    </div>
</div>
<form action="{{route('filter-proxy')}}" class="form-filter" data-category-url="{{{ UrlBuilder::getUrl($category)}}}">
    <div class="row">

        @foreach ($filter['filterVariants'] as $lensData)
            @include("client.categories._filter._{$lensData['view']}")
        @endforeach

    </div>
    <div class="filter-footer">
        <div class="form-row flex-nowrap justify-content-between">
            @isset($filter['currentFilterQuery']['category'])
                <input type="hidden" name="category" value="{{ $filter['currentFilterQuery']['category'] }}"/>
            @endisset
            <input type="hidden" name="sort" value="{{ $filter['currentFilterQuery']['sort'] }}"/>
            <input type="hidden" name="view" value="{{ $filter['currentFilterQuery']['view'] }}"/>
            @isset($filter['currentFilterQuery']['product_type_page'])
                <input type="hidden" name="product_type_page"
                       value="{{ $filter['currentFilterQuery']['product_type_page'] }}"/>
            @endisset
        </div>
    </div>
</form>
