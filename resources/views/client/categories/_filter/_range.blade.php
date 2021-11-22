<div class="filter-group-content">
    <div class="filter-range-slider-block">
        <div class="filter-range-slider"
             data-decimals="{{ isset($lensData['variants']['decimals']) ?  $lensData['variants']['decimals'] : 0 }}"
             data-from="#filter_{{ $lensData['key']  }}_from" data-to="#filter_{{ $lensData['key']  }}_to"></div>
    </div>

    <div class="filter-range-fields-block">
        <div class="row">
            <div class="col-6">
                <input type="number" id="filter_{{ $lensData['key']  }}_from"
                       name="filter[{{ $lensData['key'] }}][from]"
                       class="filter-range-field form-control" step="any"
                       data-border="{{ $lensData['variants']['min'] }}"
                       value="{{ $lensData['variants']['from'] }}">
            </div>

            <div class="col-6">
                <input type="number" id="filter_{{ $lensData['key']  }}_to"
                       name="filter[{{ $lensData['key'] }}][to]"
                       class="filter-range-field form-control" step="any"
                       data-border="{{ $lensData['variants']['max'] }}"
                       value="{{ $lensData['variants']['to'] }}">
            </div>
        </div>
    </div>
</div>
