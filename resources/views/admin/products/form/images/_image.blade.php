<li data-element-list="element" data-element-key="{!! $imageKey !!}"
    class="{{ (old("images.{$imageKey}.full_info") == 1 || !$image->exists || $errors->has("images.{$imageKey}.*")) ? 'show-full-info' : '' }}">
    @include('admin.shared.grouped_fields._controls')

    {!! Form::hidden("images[{$imageKey}][full_info]", 0, ['data-full-info-state' => '']) !!}
    {!! Form::hidden("images[{$imageKey}][id]", $image->id) !!}

    <div class="short-info form-group">
        <div class="loaded-image image-thumb-wrapper">
            @if ($image->getAttachment('image')->exists())
                <a href="{{ $image->getAttachment('image')->getRelativePath() }}"  data-fancybox target="_blank">
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
            {!! Form::hidden("images[{$imageKey}][image__exists]", (int)!empty($image['image'])) !!}
            <div class="file-upload-container">
                @include('admin.shared._local_or_remote_file_field', ['field' => "images[{$imageKey}][image_file]"])
            </div>
        {!! Form::tbFormGroupClose() !!}
    </div>

    {!! Form::tbCheckboxBlock("images[{$imageKey}][publish]", trans('validation.attributes.publish'), $image->publish) !!}

    {!! Form::tbFormGroupOpen("images.{$imageKey}.position") !!}
        {!! Form::tbLabel("images[{$imageKey}][position]", trans('validation.attributes.position')) !!}
        {!! Form::tbText("images[{$imageKey}][position]", $image->position) !!}
    {!! Form::tbFormGroupClose() !!}

    <div class="full-info">
        {!! Form::tbFormGroupOpen("images.{$imageKey}.comment") !!}
            {!! Form::tbLabel("images[{$imageKey}][comment]", trans('validation.attributes.comment')) !!}
            {!! Form::tbTinymceTextarea("images[{$imageKey}][comment]", $image->comment) !!}
        {!! Form::tbFormGroupClose() !!}
    </div>
</li>
