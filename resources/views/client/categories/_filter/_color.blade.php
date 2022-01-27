<div class="filter-column col-12 col-sm-6 col-md-4 col-xl-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title">{!! $lensData['name']  !!}</div>
        </div>

        <div class="filter-group-content">
            <div class="filter-color-list d-flex flex-wrap">

                @foreach ($lensData['variants'] as $number => $variant)

                    <div class="filter-color custom-control custom-color">
                        <input type="checkbox" class="custom-control-input"
                               id="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                               name="filter[{{ $lensData['key'] }}][]" value="{{ $variant['value'] }}"
                               {{ $variant['checked'] ? 'checked="checked"' : '' }}
                               @if (!$variant['available']) disabled @endif
                        >
                        <label for="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                               class="custom-control-label">

                            <img loading="lazy"
                                 src="{{$variant['icon']}}"
                                 alt="{{ $variant['name'] }}"
                                 class="custom-control-image">
                        </label>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>
