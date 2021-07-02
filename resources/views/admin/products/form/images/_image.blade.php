<li data-element-list="element" data-element-key="{!! $imageKey !!}" class="{{ (old("images.{$imageKey}.full_info") == 1 || !$image->exists) ? 'show-full-info' : '' }}">

    {!! Form::hidden("images[{$imageKey}][full_info]", 0, ['data-full-info-state' => '']) !!}
    {!! Form::hidden("images[{$imageKey}][id]", $image->id) !!}

    <div class="short-info form-group">
        <div class="loaded-image image-thumb-wrapper">
            @if ($image->getAttachment('image')->exists())
                <a href="{{ $image->getAttachment('image')->getRelativePath() }}" target="_blank" data-fancybox>
                    <img src="{{ $image->getAttachment('image')->getRelativePath('thumb') }}" alt="" />
                </a>
            @else
                <img src="/images/common/no-image/no-image-100x100.png" alt="" />
            @endif
        </div>
    </div>

    <div class="full-info">
        {!! Form::tbFormGroupOpen("images.{$imageKey}.image_file") !!}
            {!! Form::tbLabel("images[{$imageKey}][image]", trans('validation.attributes.image')) !!}
            @if ($image->getAttachment('image')->exists())
                <div class="loaded-image">
                    <a href="{{ $image->getAttachment('image')->getRelativePath() }}" target="_blank" data-fancybox>
                        <img src="{{ $image->getAttachment('image')->getRelativePath('thumb') }}" />
                    </a>
                </div>
            @endif
        {!! Form::tbFormGroupClose() !!}
    </div>
</li>
