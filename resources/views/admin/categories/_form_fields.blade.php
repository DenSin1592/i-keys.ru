{{-- Form fields for category --}}

{!! Form::tbFormGroupOpen('parent_id') !!}
    {!! Form::tbLabel('parent_id', trans('validation.attributes.parent_id')) !!}
    {!! Form::tbSelect2('parent_id', $formData['parentVariants']) !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbTextBlock('name') !!}

{!! Form::tbTextBlock('alias') !!}

{!! Form::tbTextBlock('path_to_icon') !!}

{!! Form::tbCheckboxBlock('publish') !!}
{!! Form::tbCheckboxBlock('menu_top') !!}
{!! Form::tbCheckboxBlock('menu_bottom') !!}

@include('admin.shared._header_meta_field')

{!! Form::tbTinymceTextareaBlock('content_for_submenu') !!}

{!! Form::tbTinymceTextareaBlock('content_for_links_type') !!}

{!! Form::tbTinymceTextareaBlock('top_content') !!}

{!! Form::tbTinymceTextareaBlock('bottom_content') !!}

@include('admin.shared._form_meta_fields')

@include('admin.shared._model_timestamps', ['model' => $formData['category']])
