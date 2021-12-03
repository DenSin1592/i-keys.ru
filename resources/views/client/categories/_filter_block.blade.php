<div class="filter-header d-none d-xl-block">
    <div class="filter-title title-h3 text-uppercase">
        <svg class="filter-title-media" width="33" height="30">
            <use xlink:href="{{asset('/images/client/sprite.svg#icon-filter')}}"></use>
        </svg>
        Фильтр
    </div>
</div>
<form action="{{route('filter-proxy')}}" class="form-filter" data-category-url="{{{ UrlBuilder::getUrl($category)}}}">
    <div class="row">

        <div class="filter-column col-12 col-sm-6 col-md-4 col-xl-12">

            @foreach ($filter['filterVariants'] as $lensData)
                    @include("client.categories._filter._{$lensData['view']}")
            @endforeach
        </div>

    </div>
    <div class="filter-footer">
        <div class="form-row flex-nowrap justify-content-between">
            @if(isset($filter['currentFilterQuery']['category']))
                <input type="hidden" name="category" value="{{ $filter['currentFilterQuery']['category'] }}"/>
            @endif
            <input type="hidden" name="sort" value="{{ $filter['currentFilterQuery']['sort'] }}"/>
            <input type="hidden" name="view" value="{{ $filter['currentFilterQuery']['view'] }}"/>
            @if(isset($filter['currentFilterQuery']['product_type_page']))
                <input type="hidden" name="product_type_page"
                       value="{{ $filter['currentFilterQuery']['product_type_page'] }}"/>
            @endif
        </div>
    </div>
</form>
