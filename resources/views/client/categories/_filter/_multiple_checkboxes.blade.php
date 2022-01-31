<div class="filter-column col-12 col-sm-6 col-md-4 col-lg-12">
    <div class="filter-group">
        <div class="filter-group-header">
            <div class="filter-group-title">{!! $lensData['name']  !!}</div>
        </div>

        <div class="filter-group-content">
            <ul class="filter-checkbox-list list-unstyled">
                @foreach ($lensData['variants'] as $number => $variant)
                    @if($lensData['key']==='lock_type' && $loop->first)
                    <li class="filter-checkbox-item" >
                        <a href="{{route('catalog', [\App\Models\Category::CYLINDERS_ALIAS])}}" class="filter-category-link d-flex align-items-center" >
                            <svg class="filter-category-media" width="24" height="24">
                                <use xlink:href="{{asset('/images/client/sprite.svg#icon-catalog-cylinder')}}"></use>
                            </svg>
                            <span class="filter-category-text" >Цилиндры</span>
                        </a>
                    </li>
                    @endif
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
                                   class="custom-control-label">{{ $variant['name'] }}
                                {!! $variant['icon_sprite'] !!}
                            </label>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>
