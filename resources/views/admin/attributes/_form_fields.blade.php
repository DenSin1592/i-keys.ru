
{!! Form::tbTextBlock('name') !!}

{!! Form::tbFormGroupOpen('code_1c') !!}
    {!! Form::tbLabel('code_1c', trans('validation.attributes.code_1c')) !!}
    {!! Form::tbText('code_1c') !!}
{!! Form::tbFormGroupClose() !!}

@include('admin.attributes.form._attribute_type', ['formData' => $formData])

{!! Form::tbTextBlock('alias', null, null, [
    'hint' => "Псевдоним URL для формирования адреса фильтра. Используется для числовых параметров: [псевдоним]-ot-500-do-9000." .
        '<br /> Также определяет приоритет, какие из 4-ёх параметров попадут в динамически формируемых заголовок (h1) на странице фильтра'
]) !!}

@include('admin.attributes.form.categories._block')

@include('admin.shared._model_timestamps', ['model' => $formData['attribute']])
