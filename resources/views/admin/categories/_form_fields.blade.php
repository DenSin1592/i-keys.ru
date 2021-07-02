{{-- Form fields for category --}}

{!! Form::tbFormGroupOpen('parent_id') !!}
    {!! Form::tbLabel('parent_id', trans('validation.attributes.parent_id')) !!}
    {!! Form::tbSelect2('parent_id', $formData['parentVariants']) !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('catalog_type') !!}
    {!! Form::tbLabel('catalog_type', trans('validation.attributes.catalog_type')) !!}
    {!! Form::tbSelect2('catalog_type', $formData['catalogTypeVariants']) !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbTextBlock('name') !!}

{!! Form::tbTextBlock('alias') !!}

{!! Form::tbCheckboxBlock('publish') !!}

@include('admin.shared._header_meta_field')

{!! Form::tbTinymceTextareaBlock('top_content') !!}

{!! Form::tbTinymceTextareaBlock('content') !!}

{!! Form::tbTinymceTextareaBlock('bottom_content') !!}

@include('admin.shared._form_meta_fields')

@include('admin.shared._model_timestamps', ['model' => $formData['category']])
