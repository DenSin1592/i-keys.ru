<div class="filter-column col-12 col-sm-6 col-md-4 col-xl-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title title-h4">{!! $lensData['name']  !!}</div>
        </div>

        <div class="filter-group-content">
            <ul class="filter-checkbox-list list-unstyled">
                @foreach ($lensData['variants'] as $number => $variant)
                    <li class="filter-checkbox-item">
                        <div class="filter-checkbox custom-control custom-checkbox">

                            <input type="checkbox"
                                   id="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                                   class="custom-control-input"
                                   name="filter[{{ $lensData['key'] }}][]"
                                   {{ $variant['checked'] ? 'checked="checked"' : '' }}
                                   value="{{ $variant['value'] }}"
                                   @if (!$variant['available']) disabled="disabled" @endif>

                            <label for="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                                   class="custom-control-label">{{ $variant['name'] }}</label>
                        </div>

                        @isset($variant['series_variants'])

                            <ul class="filter-checkbox-list list-unstyled">
                                @foreach($variant['series_variants'] as $seriesVariant)
                                <li class="filter-checkbox-item">
                                    <div class="filter-checkbox custom-control custom-checkbox">
                                        <input
                                            type="checkbox"
                                            id="filter_{{ $seriesVariant['lens_key'] . '_' . $seriesVariant['value'] }}"
                                            class="custom-control-input"
                                            name="filter[{{ $seriesVariant['lens_key'] }}][]"
                                            {{ $seriesVariant['checked'] ? 'checked="checked"' : '' }}
                                            value="{{ $seriesVariant['value'] }}"
                                            @if (!$seriesVariant['available']) disabled="disabled" @endif
                                        >
                                        <label for="filter_{{ $seriesVariant['lens_key'] . '_' . $seriesVariant['value'] }}"
                                               class="custom-control-label">{{$seriesVariant['name']}}</label>
                                    </div>

{{--                                    <button type="button" class="filter-tooltip-toggle tooltip-toggle" data-toggle="tooltip" data-placement="right" title="Далеко-далеко, за словесными.">?</button>--}}
                                </li>
                                @endforeach
                            </ul>

                        @endisset

                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
