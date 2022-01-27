<li data-element-list="element" data-element-key="{!! $allowedValueKey !!}" class="short-info-allowed-value {{ (old("allowed_values.{$allowedValueKey}.full_info") == 1 || !$allowedValue->exists) ? 'show-full-info' : '' }}">
    @include('admin.shared.grouped_fields._controls')

    {!! Form::hidden("allowed_values[{$allowedValueKey}][full_info]", 0, ['data-full-info-state' => '']) !!}
    {!! Form::hidden("allowed_values[{$allowedValueKey}][id]", $allowedValue->id) !!}

    {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.value") !!}
        {!! Form::tbLabel("allowed_values[{$allowedValueKey}][value]", trans('validation.attributes.value')) !!}
        {!! Form::tbText("allowed_values[{$allowedValueKey}][value]", $allowedValue->value) !!}
    {!! Form::tbFormGroupClose() !!}

{{--    @include('admin.shared._model_image_field', ['model' => $allowedValue, 'field' => "allowed_values[{$allowedValueKey}][icon]"])--}}



    <div class="full-info">

        {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.icon_file") !!}
        {!! Form::tbLabel("allowed_values[{$allowedValueKey}][icon]", trans('validation.attributes.icon_file')) !!}
{{--        <div class="field-hint-block">Рекомендуемый размер изображения - 50х50 px. Рекомендуемый формат - svg</div>--}}
        @if ($allowedValue->getAttachment('icon')->exists())
            <div class="loaded-image">
                <a href="{{{ $allowedValue->getAttachment('icon')->getRelativePath() }}}" target="_blank" rel="prettyPhoto" data-fancybox="">
                    <img src="{{{ $allowedValue->getAttachment('icon')->getRelativePath() }}}" alt="" width="50" height="50"/>
                </a>
                <label>
                    {{ Form::checkbox("allowed_values[{$allowedValueKey}][icon_remove]", 1) }}
                    удалить
                </label>
            </div>
        @endif
        <div class="file-upload-container">
            @include('admin.shared._local_or_remote_file_field', ['field' => "allowed_values[{$allowedValueKey}][icon_file]"])
        </div>
        {!! Form::tbFormGroupClose() !!}

        {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.svg_path") !!}
        {!! Form::tbLabel("allowed_values[{$allowedValueKey}][svg_path]", trans('validation.attributes.svg_path_sprite')) !!}
        {!! Form::tbText("allowed_values[{$allowedValueKey}][svg_path]", $allowedValue->svg_path) !!}
        {!! Form::tbFormGroupClose() !!}

        @if($code1c === \App\Models\Attribute\AttributeConstants::SIZE_CYLINDER_1C_CODE)

            {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.value_first_size_cylinder") !!}
            {!! Form::tbLabel("allowed_values[{$allowedValueKey}][value_first_size_cylinder]", trans('validation.attributes.value_first_size_cylinder')) !!}
            {!! Form::tbText("allowed_values[{$allowedValueKey}][value_first_size_cylinder]", $allowedValue->value_first_size_cylinder) !!}
            {!! Form::tbFormGroupClose() !!}

            {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.value_second_size_cylinder") !!}
            {!! Form::tbLabel("allowed_values[{$allowedValueKey}][value_second_size_cylinder]", trans('validation.attributes.value_second_size_cylinder')) !!}
            {!! Form::tbText("allowed_values[{$allowedValueKey}][value_second_size_cylinder]", $allowedValue->value_second_size_cylinder) !!}
            {!! Form::tbFormGroupClose() !!}

        @endif

    </div>
</li>
