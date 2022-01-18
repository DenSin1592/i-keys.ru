@extends('admin.attributes.inner')

@section('title')
    Редактирование услуги "{{ $formData['service']->name }}"
@stop

@section('content')

    {!! Form::tbModelWithErrors($formData['service'], $errors, ['url' => route('cc.services.update', [$formData['service']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']) !!}

        @include('admin.services._form_fields')

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.create_and_back_to_list') }}</button>
            <a href="{{ route('cc.services.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            <a href="{{ route('service.show', [$formData['service']->alias]) }}" class="btn btn-default" target="_blank">
                {{ trans('interactions.show_on_site') }}
            </a>
        </div>

    {!! Form::close() !!}
@stop
