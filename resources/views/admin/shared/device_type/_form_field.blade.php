@if($model->exists && \Auth::guard('admin')->user()->super)
    {!! Form::tbFormGroupOpen('device_type') !!}
        {!! Form::tbLabel('device_type', trans('validation.attributes.device_type')) !!}:
        @if(!empty($model->device_type))
            {!! trans('validation.model_attributes.device_type.' . $model->device_type) !!}
        @else
            <i>нет информации</i>
        @endif
    {!! Form::tbFormGroupClose() !!}

    {!! Form::tbFormGroupOpen('user_agent') !!}
        {!! Form::tbLabel('user_agent', trans('validation.attributes.user_agent')) !!}:
        @if(!empty($model->user_agent))
            {!! $model->user_agent !!}
        @else
            <i>нет информации</i>
        @endif
    {!! Form::tbFormGroupClose() !!}
@endif

