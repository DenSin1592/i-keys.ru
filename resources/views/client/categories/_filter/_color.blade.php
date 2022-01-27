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

                                @switch($variant['value'])
                                    @case(\App\Models\Attribute\AttributeConstants::COLOR_LATUN_ID)
                                        src="{{asset('/uploads/colors/color-brown.png')}}"
                                        @break
                                    @case(\App\Models\Attribute\AttributeConstants::COLOR_NICKEL_ID)
                                        src="{{asset('/uploads/colors/color-silver.png')}}"
                                        @break
                                    @default
                                        src="{{asset('/images/common/no-image/no-image-40x40.png')}}"
                                 @endswitch


                                 alt="{{ $variant['name'] }}"
                                 class="custom-control-image">
                        </label>
                    </div>

                @endforeach
            </div>
        </div>
    </div>
</div>
