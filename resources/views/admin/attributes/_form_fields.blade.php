
{!! Form::tbTextBlock('name') !!}

@include('admin.shared._model_image_field', ['model' => $formData['attribute'], 'field' => 'icon'])

{!! Form::tbCheckboxBlock('hidden', trans('validation.model_attributes.attribute.hidden'), null, ['hint' => 'Параметр не будет выводиться на странице товара, но по прежнему может участвовать в фильтре.']) !!}

@include('admin.attributes.form._attribute_type', ['formData' => $formData])

{!! Form::tbCheckboxBlock('use_in_filter') !!}

{!! Form::tbCheckboxBlock('for_admin_filter', null, null, ['hint' => 'Параметр доступен только в фильтре администратора. В обычном фильтре клиента скрыто.']) !!}

{!! Form::tbTextBlock('filter_name') !!}

{!! Form::tbTextBlock('alias', null, null, [
    'hint' => "Псевдоним URL для формирования адреса фильтра. Используется для числовых параметров: [псевдоним]-ot-500-do-9000." .
        '<br /> Также определяет приоритет, какие из 4-ёх параметров попадут в динамически формируемых заголовок (h1) на странице фильтра'
]) !!}

@include('admin.attributes.form.categories._block')

@include('admin.shared._model_timestamps', ['model' => $formData['attribute']])
