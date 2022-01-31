<div class="filter-column col-12 col-sm-6 col-md-4 col-lg-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title">{!! $lensData['name']  !!}</div>
        </div>

        <div class="filter-group-content">
            <div class="filter-sheme-options-block">
                <div class="row flex-nowrap no-gutters">
                    <div class="filter-sheme-option-column col-5">
                        <div class="filter-sheme-option-group">
                            <label for="filter_{{ $lensData['key']  }}_first" class="filter-sheme-option-title">Внеш.</label>

                            <select name="filter[{{ $lensData['key'] }}][]"
                                    id="filter_{{ $lensData['key']  }}_first"
                                    class="filter-sheme-option-select custom-control custom-select"
                                    style="width: 100%;">

                                <option value="" data-default="1">-----</option>

                                @foreach ($lensData['variants']['first_size'] as $number => $variant)
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
                            <label for="filter_{{ $lensData['key']  }}_second" class="filter-sheme-option-title">Внутр.</label>

                            <select name="filter[{{ $lensData['key'] }}][]"
                                    id="filter_{{ $lensData['key']  }}_second"
                                    class="filter-sheme-option-select custom-control custom-select"
                                    style="width: 100%;">

                                <option value="" data-default="1">-----</option>

                                @foreach ($lensData['variants']['second_size'] as $number => $variant)
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
