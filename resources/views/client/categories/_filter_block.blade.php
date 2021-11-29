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
            <div class="filter-group filter-category-group">
                <div class="filter-group-content">
                    <ul class="filter-options-list list-unstyled">
                        <li class="filter-option-item">
                            <div class="filter-option">
                                <input type="radio" id="filter-option-category-3" class="filter-option-input"
                                       name="test">
                                <label for="filter-option-category-3" class="filter-option-label">
                                    Показать все
                                    {{--                                    <span class="filter-option-badge">123</span>--}}
                                </label>
                            </div>
                        </li>

                        <li class="filter-option-item">
                            <div class="filter-option">
                                <input type="radio" id="filter-option-category-1" class="filter-option-input"
                                       name="test">
                                <label for="filter-option-category-1" class="filter-option-label">
                                    Показать лучшие товары
{{--                                    <span class="filter-option-badge">13</span>--}}
                                </label>
                            </div>
                        </li>

                        <li class="filter-option-item">
                            <div class="filter-option">
                                <input type="radio" id="filter-option-category-2" class="filter-option-input"
                                       name="test">
                                <label for="filter-option-category-2" class="filter-option-label">
                                    Показать товары со скидками
{{--                                    <span class="filter-option-badge">25</span>--}}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>


        <div class="filter-column col-12 col-sm-6 col-md-4 col-xl-12">

            @foreach ($filter['filterVariants'] as $lensData)
                <div class="filter-group">
                    <div class="filter-group-header">
                        <div class="filter-group-title title-h4">{!! $lensData['name']  !!}</div>
                    </div>
                    @include("client.categories._filter._{$lensData['view']}")
                </div>
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
