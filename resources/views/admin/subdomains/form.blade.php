
{!! Form::tbTextBlock('city_name', trans('validation.attributes.city_name')) !!}

{!! Form::tbTextBlock('name', trans('validation.attributes.name')) !!}


{!! Form::tbTextareaBlock('robots_txt', trans('validation.attributes.robots_txt')) !!}

{!! Form::tbTextareaBlock('google_analytics', trans('validation.attributes.google_analytics')) !!}

{!! Form::tbTextareaBlock('yandex_metrika', trans('validation.attributes.yandex_metrika')) !!}

{!! Form::tbTextareaBlock('live_internet', trans('validation.attributes.live_internet')) !!}


{!! Form::tbTextBlock('header_template', trans('validation.attributes.header_template')) !!}

{!! Form::tbTextBlock('meta_title_template', trans('validation.attributes.meta_title_template')) !!}

{!! Form::tbTextBlock('meta_description_template', trans('validation.attributes.meta_description_template')) !!}

{!! Form::tbTextBlock('meta_keywords_template', trans('validation.attributes.meta_keywords_template')) !!}


@include('admin.shared._model_timestamps', ['model' => $formData['entity']])



