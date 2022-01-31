<div class="filter-column col-12 col-sm-6 col-md-4 col-lg-12">
    <div class="filter-group filter-category-group">
        <div class="filter-group-content">
            <ul class="filter-options-list list-unstyled">

                @foreach ($lensData['variants'] as $number => $variant)
                    <li class="filter-option-item">
                        <div class="filter-option">
                            <input type="radio"
                                   id="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                                   class="filter-option-input"
                                   name="filter[{{ $lensData['key'] }}][]"
                                   {{ $variant['checked'] ? 'checked="checked"' : '' }}
                                   value="{{ $variant['value'] }}"
                                   @if (!$variant['available']) disabled="disabled" @endif
                            >
                            <label for="filter_{{ $lensData['key'] . '_' . $variant['value'] }}"
                                   class="filter-option-label">
                                {{ $variant['name'] }}
                                <span class="filter-option-badge">{{$variant['count']}}</span>
                            </label>
                        </div>
                    </li>
                @endforeach

            </ul>
        </div>
    </div>
</div>
