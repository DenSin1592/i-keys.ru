{{-- Form fields for attribute --}}
{!! Form::hidden('category_id', $formData['category']->id) !!}

{!! Form::tbFormGroupOpen('name') !!}
{!! Form::tbLabel('name', trans('validation.attributes.name')) !!}
{!! Form::tbText('name') !!}
{!! Form::tbFormGroupClose() !!}


@include('admin.attributes.form._attribute_type', ['formData' => $formData])
@include('admin.shared._model_timestamps', ['model' => $formData['attribute']])
