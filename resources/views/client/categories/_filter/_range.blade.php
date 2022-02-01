<div class="filter-column col-12 col-sm-6 col-md-4 col-lg-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title">{!! $lensData['name']  !!}</div>
        </div>

        <div class="filter-group-content">
            <div class="filter-range-slider-block">
                <div class="filter-range-slider"
                     data-decimals="{{ isset($lensData['variants']['decimals']) ?  $lensData['variants']['decimals'] : 0 }}"
                     data-from="#filter_{{ $lensData['key']  }}_from"
                     data-to="#filter_{{ $lensData['key']  }}_to"
                     @if($lensData['variants']['disabled']) disabled="disabled"  @endif
                ></div>
            </div>

            <div class="filter-range-fields-block">
                <div class="row">
                    <div class="col-6">
                        <input type="number" id="filter_{{ $lensData['key']  }}_from"
                               name="filter[{{ $lensData['key'] }}][from]"
                               class="filter-range-field form-control" step="any"
                               data-border="{{ $lensData['variants']['min'] }}"
                               value="{{ $lensData['variants']['from'] }}"
                               @if($lensData['variants']['disabled']) disabled="disabled"  @endif
                        >
                    </div>

                    <div class="col-6">
                        <input type="number" id="filter_{{ $lensData['key']  }}_to"
                               name="filter[{{ $lensData['key'] }}][to]"
                               class="filter-range-field form-control" step="any"
                               data-border="{{ $lensData['variants']['max'] }}"
                               value="{{ $lensData['variants']['to'] }}"
                               @if($lensData['variants']['disabled']) disabled="disabled"  @endif
                        >
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
