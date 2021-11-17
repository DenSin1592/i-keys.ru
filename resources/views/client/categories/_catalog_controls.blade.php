{{--
@if (count($productsData) > 0)
<div class="catalog-controls">
    <div class="row align-items-sm-center">
        <div class="col">
            <label for="catalog-sort" class="mb-0" >Сортировать по:</label>

            <div class="d-sm-inline-block">
                <select id="products-sort" class="select2 select2-link" >
                    @foreach(\Arr::get($filter, 'sortingVariants', []) as $sortVariant)
                    <option value="{{ CatalogHelper::getSortingUrl(\Arr::get($filter, 'currentFilterQuery', []), $sortVariant['key']) }}"
                            {{ $sortVariant['active'] ? 'selected' : '' }}>{!! $sortVariant['name'] !!}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="col col-catalog-controls">
            <ul class="catalog-view">
                <li class="item icon-grid {{ \Arr::get($filter, 'currentFilterQuery.view') !== \App\Models\Product::VIEW_LIST ? 'active' : '' }} ">
                    <a href="{{
                        \Arr::get($filter, 'currentFilterQuery.view') !== \App\Models\Product::VIEW_LIST ?
                        'javascript:void(0);' :
                        \Helper::urlWithProductsView(\Url::full(), null)
                        }}" class="link">
                        <img src="{{ Asset::timed('images/client/icons/icon-grid.svg') }}" alt="Вид сеткой">
                    </a>
                </li>
                <li class="item icon-list {{ \Arr::get($filter, 'currentFilterQuery.view') === \App\Models\Product::VIEW_LIST ? 'active' : '' }}">
                    <a href="{{
                        \Arr::get($filter, 'currentFilterQuery.view') === \App\Models\Product::VIEW_LIST ?
                        'javascript:void(0);' :
                        \Helper::urlWithProductsView(\Url::full(), \App\Models\Product::VIEW_LIST) }}" class="link">
                        <img src="{{ Asset::timed('images/client/icons/icon-list.svg') }}" alt="Вид списком">
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
@endif--}}

<div class="catalog-controls-block">
    <div class="row justify-content-between">
        <div class="catalog-sort-container col-auto">
            <div class="catalog-sort-block">
                <form action="" class="form-catalog-sort">
                    <fieldset>
                        <div class="form-row">
                            <div class="col-auto">
                                <label class="catalog-sort-title" for="catalog-sort-select" >Сортировать по</label>
                            </div>

                            <div class="col-auto">
                                <select name="" id="catalog-sort-select" class="catalog-sort-select custom-control custom-select" >
                                    <option value="Сначала дешевые">Сначала дешевые</option>
                                    <option value="Сначала дороже">Сначала дороже</option>
                                </select>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        <div class="catalog-view-container col-auto">
            <div class="catalog-view-block">
                <ul class="catalog-view-list list-unstyled d-flex flex-wrap">
                    <li class="catalog-view-item active">
                        <button type="button" class="catalog-view-button" >
                            <svg class="catalog-view-media" width="32" height="32">
                                <use xlink:href="/images/sprite.svg#icon-grid"></use>
                            </svg>
                        </button>
                    </li>

                    <li class="catalog-view-item">
                        <button type="button" class="catalog-view-button" >
                            <svg class="catalog-view-media" width="32" height="32">
                                <use xlink:href="/images/sprite.svg#icon-list"></use>
                            </svg>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
