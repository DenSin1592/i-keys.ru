{{-- Timestamps for form --}}

@if (isset($model->created_at))
    {!! Form::tbFormGroupOpen() !!}
        <label>{{ trans('validation.attributes.created_at') }}</label><br/>
        {{ $model->created_at->format('H:i:s d.m.Y') }}
    {!! Form::tbFormGroupClose() !!}
@endif

@if (isset($model->updated_at))
    {!! Form::tbFormGroupOpen() !!}
        <label>{{ trans('validation.attributes.updated_at') }}</label><br/>
        {{ $model->updated_at->format('H:i:s d.m.Y') }}
    {!! Form::tbFormGroupClose() !!}
@endif
