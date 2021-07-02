@foreach ($formData['attributes'] as $attribute)
    {!! Form::tbFormGroupOpen("attributes.{$attribute['attribute']->id}") !!}
        {!! Form::tbLabel("attributes[{$attribute['attribute']->id}]", $attribute['attribute']->name) !!}
        @include("admin.products.form.attributes._attribute_{$attribute['attribute']->attribute_type}")
    {!! Form::tbFormGroupClose() !!}
@endforeach
