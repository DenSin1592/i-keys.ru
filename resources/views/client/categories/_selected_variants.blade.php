{{--@if(!empty($filter['filterVariants']))
    <div id="filter-reset" class="selected-variants">
        @foreach($filter['filterVariants'] as $variant)
        @if ($variant['view'] == 'range')
            @if ($variant['optional']['checked'])
                <div class="catalog-selection-button"
                     data-type="range"
                     data-id-from="filter_{{ $variant['key'] }}_from"
                     data-id-to="filter_{{ $variant['key'] }}_to">
                    {{ $variant['variants']['from'] }} — {{ $variant['variants']['to'] }}
                    @if ($variant['variants']['units'] != '')
                    {{ $variant['variants']['units'] }}
                    @endif

                    <button type="button" class="close catalog-selection-remove" ></button>
                </div>
            @endif
        @elseif ($variant['view'] == 'multiple_checkboxes')
            @foreach($variant['variants'] as $value)
                @if ($value['checked'])
                    <div class="catalog-selection-button"
                         data-type="choice"
                         data-id="filter_{{ $variant['key'] }}_{{ $value['value'] }}">
                        {{ $value['name'] }}
                        <button type="button" class="close catalog-selection-remove" data-attribute-id="filter_{{ $variant['key'] }}_{{$value['value']}}"></button>
                    </div>
                @endif
            @endforeach

        @endif
        @endforeach
        @foreach($filter['filterVariants'] as $variant)
        @if ($variant['optional']['checked'])
        <div class="catalog-selection-button reset"
             data-reset-filter="1"
             data-url="{{ UrlBuilder::getUrl($category) }}">
            Очистить все
            <button type="button" class="close catalog-selection-remove" data-url="{{ UrlBuilder::getUrl($category) }}"></button>
        </div>
        @break
        @endif
        @endforeach
    </div>
@endif--}}

<div class="catalog-selected-options-block">
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
                <li class="catalog-selected-option-item">
                    <div class="catalog-selected-option">
                        Лучшие товары
                        <button type="button" class="catalog-selected-option-remove">
                            <svg class="catalog-selected-option-media" width="8" height="8">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-close')}}"></use>
                            </svg>
                        </button>
                    </div>
                </li>

                <li class="catalog-selected-option-item">
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
