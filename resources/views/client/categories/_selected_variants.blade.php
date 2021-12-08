@if (($filter['isSelectedFilterVariants']))

    <div class="catalog-selected-options-block" id="filter-reset">
        <div class="form-row">
            <div class="col-auto">
                <div class="catalog-selected-options-title">
                    <svg class="catalog-selected-options-media" width="15" height="15">
                        <use xlink:href="{{asset('/images/client/sprite.svg#icon-filter')}}"></use>
                    </svg>
                    Выбранные фильтры
                </div>
            </div>

            <div class="col-auto">
                <ul class="catalog-selected-options-list list-unstyled d-flex flex-wrap">


                    @foreach($filter['filterVariants'] as $variant)
                        @if ($variant['optional']['checked'] && $variant['view'] === 'range')

                                <li class="catalog-selected-option-item">
                                    <div class="catalog-selected-option"
                                         data-type="range"
                                         data-id-from="filter_{{ $variant['key'] }}_from"
                                         data-id-to="filter_{{ $variant['key'] }}_to"
                                    >
                                        {{ $variant['variants']['from'] }} — {{ $variant['variants']['to'] }}
                                        @if ($variant['variants']['units'] != '')
                                            {{ $variant['variants']['units'] }}
                                        @endif
                                        <button type="button"
                                                class="catalog-selected-option-remove catalog-selection-remove">
                                            <svg class="catalog-selected-option-media" width="8" height="8">
                                                <use
                                                    xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                                            </svg>
                                        </button>
                                    </div>
                                </li>
                            @continue
                        @endif

                        @if ($variant['optional']['checked'] && in_array($variant['view'], \App\Providers\CatalogServiceProvider::MULTIPLE_VIEWS_FOR_SELECTED_BLOCK))
                            @foreach($variant['variants'] as $value)
                                @if ($value['checked'])
                                    <li class="catalog-selected-option-item">
                                        <div class="catalog-selected-option"
                                             data-type="choice"
                                             data-id="filter_{{ $variant['key'] }}_{{ $value['value'] }}"
                                        >
                                            {{ $value['name'] }}
                                            <button type="button"
                                                    class="catalog-selected-option-remove catalog-selection-remove"
                                                    data-attribute-id="filter_{{ $variant['key'] }}_{{$value['value']}}">
                                                <svg class="catalog-selected-option-media" width="8" height="8">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                            @continue
                        @endif

                        @if ($variant['optional']['checked'] && $variant['view'] === 'cylinder_size')
                            @foreach($variant['variants']['first_size'] as $value)
                                @if ($value['checked'])
                                    @php $first_size_checked = true; @endphp
                                    <li class="catalog-selected-option-item">
                                        <div class="catalog-selected-option"
                                             data-type="cylinder_size"
                                             data-id-first="filter_{{ $variant['key'] }}_first"
                                             data-id-second="filter_{{ $variant['key'] }}_second"
                                        >
                                            {{ $value['value'] . 'мм' }}
                                            @foreach($variant['variants']['second_size'] as $value2)
                                                @if ($value2['checked'])
                                                    {{{'x ' . $value2['value'] . 'мм' }}}
                                                @endif
                                            @endforeach
                                            <button type="button"
                                                    class="catalog-selected-option-remove catalog-selection-remove">
                                                <svg class="catalog-selected-option-media" width="8" height="8">
                                                    <use
                                                        xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                                                </svg>
                                            </button>
                                        </div>
                                    </li>
                                @endif
                            @endforeach

                            @if(empty($first_size_checked))
                                @foreach($variant['variants']['second_size'] as $value2)
                                    @if ($value2['checked'])
                                        <li class="catalog-selected-option-item">
                                            <div class="catalog-selected-option"
                                                 data-type="cylinder_size"
                                                 data-id-first="filter_{{ $variant['key'] }}_first"
                                                 data-id-second="filter_{{ $variant['key'] }}_second"
                                            >
                                                {{ $value2['value'] . 'мм' }}
                                                <button type="button"
                                                        class="catalog-selected-option-remove catalog-selection-remove">
                                                    <svg class="catalog-selected-option-media" width="8" height="8">
                                                        <use
                                                            xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                                                    </svg>
                                                </button>
                                            </div>
                                        </li>
                                    @endif
                                @endforeach
                            @endif
                            @continue
                        @endif


                    @endforeach

                    <li class="catalog-selected-option-item"
                        data-reset-filter="1"
                        data-url="{{ UrlBuilder::getUrl($category) }}">
                        <button type="button" class="catalog-selected-option-reset">
                            Сбросить все
                            <svg class="catalog-selected-option-media" width="8" height="8">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                            </svg>
                        </button>
                    </li>

                </ul>
            </div>
        </div>
    </div>
@endif
