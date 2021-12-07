<div class="filter-column col-12 col-sm-6 col-md-4 col-xl-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title title-h4">{!! $lensData['name']  !!}</div>
        </div>

        <div class="filter-group-content">
            <div class="filter-sheme-options-block">
                <div class="row flex-nowrap no-gutters">
                    <div class="filter-sheme-option-column col-5">
                        <div class="filter-sheme-option-group">
                            <label for="filter-sheme-option-1" class="filter-sheme-option-title">Внеш.</label>

                            <select name="filter[{{ $lensData['key'] }}][]"
                                    id="filter-sheme-option-1"
                                    class="filter-sheme-option-select custom-control custom-select"
                                    style="width: 100%;">
                                <option value="">-----</option>
                                @foreach ($lensData['variants'] as $number => $variant)
                                <option value="{{ $variant['value'] }}"
                                        @if (!$variant['available']) disabled @endif
                                    {{ $variant['checked'] ? 'selected' : '' }}
                                >
                                    {{ $variant['value'] . 'мм'}}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="filter-sheme-option-column col-7">
                        <div class="filter-sheme-option-group">
                            <label for="filter-sheme-option-2" class="filter-sheme-option-title">Внутр.</label>

                            <select name="filter[{{ $lensData['key'] }}][]"
                                    id="filter-sheme-option-2"
                                    class="filter-sheme-option-select custom-control custom-select"
                                    style="width: 100%;">
                                <option value="">-----</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="filter-sheme-block">
                <div class="filter-sheme-thumbnail">
                    <img loading="lazy" src="{{asset('/images/client/filter/filter-sheme-1.png')}}" width="323"
                         height="130"
                         alt="" class="filter-sheme-media">
                </div>
            </div>
        </div>
    </div>
</div>
