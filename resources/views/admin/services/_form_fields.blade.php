
{!! Form::tbFormGroupOpen('name') !!}
{!! Form::tbLabel('name', trans('validation.attributes.name')) !!}
{!! Form::tbText('name') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('alias') !!}
{!! Form::tbLabel('alias', trans('validation.attributes.alias')) !!}
{!! Form::tbText('alias') !!}
{!! Form::tbFormGroupClose() !!}

@include('admin.shared._header_meta_field')

@include('admin.shared._model_image_field', ['model' => $formData['service'], 'field' => 'image'])

@include('admin.shared._model_image_field', ['model' => $formData['service'], 'field' => 'icon'])

{!! Form::tbCheckboxBlock('publish') !!}

{!! Form::tbFormGroupOpen('price') !!}
{!! Form::tbLabel('price', trans('validation.attributes.price')) !!}
{!! Form::tbText('price') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('description') !!}
{!! Form::tbLabel('description', trans('validation.attributes.description')) !!}
{!! Form::tbTextarea('description') !!}
{!! Form::tbFormGroupClose() !!}

{!! Form::tbFormGroupOpen('content') !!}
{!! Form::tbLabel('content', trans('validation.attributes.content')) !!}
<div>Для подстановки блока хлебных крошек используйте {{\App\Models\Service::BREADCRUMBS}}, текста H1 - {{\App\Models\Service::H1}}</div>
{!! Form::tbTextarea('content') !!}
{!! Form::tbFormGroupClose() !!}


@include('admin.shared._form_meta_fields')

@include('admin.shared._model_timestamps', ['model' => $formData['service']])
