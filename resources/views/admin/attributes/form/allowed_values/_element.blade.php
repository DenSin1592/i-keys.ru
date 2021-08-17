<li data-element-list="element" data-element-key="{!! $allowedValueKey !!}" class="short-info-allowed-value {{ (old("allowed_values.{$allowedValueKey}.full_info") == 1 || !$allowedValue->exists) ? 'show-full-info' : '' }}">
    @include('admin.shared.grouped_fields._controls')

    {!! Form::hidden("allowed_values[{$allowedValueKey}][full_info]", 0, ['data-full-info-state' => '']) !!}
    {!! Form::hidden("allowed_values[{$allowedValueKey}][id]", $allowedValue->id) !!}

    {!! Form::tbFormGroupOpen("allowed_values.{$allowedValueKey}.value") !!}
        {!! Form::tbLabel("allowed_values[{$allowedValueKey}][value]", trans('validation.attributes.value')) !!}
        {!! Form::tbText("allowed_values[{$allowedValueKey}][value]", $allowedValue->value) !!}
    {!! Form::tbFormGroupClose() !!}
</li>
