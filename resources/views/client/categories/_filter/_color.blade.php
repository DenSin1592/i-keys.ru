<div class="filter-group-content">
    <div class="filter-color-list d-flex flex-wrap">

        @foreach ($lensData['variants'] as $number => $variant)

            <div class="filter-color custom-control custom-color">
                <input type="checkbox" class="custom-control-input" id="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                       name="filter[{{ $lensData['key'] }}][]" value="{{ $variant['value'] }}"
                       {{ $variant['checked'] ? 'checked="checked"' : '' }}
                       @if (!$variant['available']) disabled @endif
                >
                <label for="filter_{{ $lensData['key'] . '_' . $variant['value'] }}" class="custom-control-label">
                    <img loading="lazy" src="/uploads/colors/color-brown.png" alt="{{ $variant['name'] }}" class="custom-control-image">
                </label>
            </div>

        @endforeach
    </div>
</div>


