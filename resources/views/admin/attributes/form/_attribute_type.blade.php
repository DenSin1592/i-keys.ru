{!! Form::tbFormGroupOpen('attribute_type') !!}
    {!! Form::tbLabel('attribute_type', trans('validation.attributes.attribute_type')) !!}
    {!! Form::tbSelect('attribute_type', $formData['attribute_type']['variants']) !!}
{!! Form::tbFormGroupClose() !!}

<div id="attribute-type-data" data-url="{{ route('cc.attributes.type-data.show', [$formData['attribute']->id]) }}">
    @include('admin.attributes.form._type_data')
</div>
