<li data-element-list="element" data-element-key="{!! $allowedValueKey !!}" class="short-info-allowed-value {{ (old("allowed_values.{$allowedValueKey}.full_info") == 1 || !$allowedValue->exists) ? 'show-full-info' : '' }}">
    @include('admin.shared.grouped_fields._controls')

    {!! Form::hidden("allowed_values[{$allowedValueKey}][full_info]", 0, ['data-full-info-state' => '']) !!}
    {!! Form::hidden("allowed_values[{$allowedValueKey}][id]", $allowedValue->id) !!}

    {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.value") !!}
        {!! Form::tbLabel("allowed_values[{$allowedValueKey}][value]", trans('validation.attributes.value')) !!}
        {!! Form::tbText("allowed_values[{$allowedValueKey}][value]", $allowedValue->value) !!}
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
</li>
