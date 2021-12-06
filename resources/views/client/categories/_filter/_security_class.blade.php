<div class="filter-column col-12 col-sm-6 col-md-4 col-xl-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title title-h4">
                <div class="filter-group-title title-h4">{!! $lensData['name']  !!}</div>
                <button type="button" class="filter-tooltip-toggle tooltip-toggle" data-toggle="tooltip" data-placement="right" title="Далеко-далеко, за словесными.">?</button>
            </div>
        </div>

        <div class="filter-group-content">
            <div class="filter-security-list d-flex flex-wrap">

                @foreach ($lensData['variants'] as $number => $variant)

                    <input type="radio"
                           value="{{ $variant['value'] }}"
                           id="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                           class="filter-security-input"
                           {{ $variant['checked'] ? 'checked="checked"' : '' }}
                           name="filter[{{ $lensData['key'] }}][]"
                           @if (!$variant['available']) disabled="disabled" @endif>

                    <label for="filter_{{ $lensData['key'] . '_' . $variant['value'] }}" class="filter-security-label">
                        <svg class="filter-security-media" width="22" height="30">
                            <use xlink:href="{{asset('/images/client/sprite.svg#icon-security')}}"></use>
                        </svg>
                    </label>

                @endforeach

            </div>
        </div>
    </div>
</div>
