{{-- Form fields for category --}}

{!! Form::tbFormGroupOpen('parent_id') !!}
    {!! Form::tbLabel('parent_id', trans('validation.attributes.parent_id')) !!}
    {!! Form::tbSelect2('parent_id', $formData['parentVariants']) !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('category_id') !!}
    {!! Form::tbLabel('category_id', trans('validation.attributes.category_id')) !!}
    {!! Form::tbSelect2('category_id', $formData['categoryVariants']) !!}
{!! Form::tbFormGroupClose() !!}


{!! Form::tbTextBlock('name') !!}

{!! Form::tbTextBlock('alias') !!}

{!! Form::tbCheckboxBlock('publish') !!}

@include('admin.shared._header_meta_field')

{!! Form::tbTinymceTextareaBlock('top_content') !!}

{!! Form::tbTinymceTextareaBlock('content') !!}

{!! Form::tbTinymceTextareaBlock('bottom_content') !!}

@include('admin.shared._form_meta_fields')

@include('admin.shared._model_timestamps', ['model' => $formData['type']])
