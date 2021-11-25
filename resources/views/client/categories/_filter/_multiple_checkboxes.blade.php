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
            </li>
        @endforeach
    </ul>
</div>
