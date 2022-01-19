@extends('admin.attributes.inner')

@section('title')
    Редактирование услуги "{{ $formData['service']->name }}"
@stop

@section('content')

    {!! Form::tbModelWithErrors($formData['service'], $errors, ['url' => route('cc.services.update', [$formData['service']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']) !!}

        @include('admin.services._form_fields')

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <a href="{{ route('cc.services.destroy', [$formData['service']->id]) }}"
               data-method="delete"
               data-confirm="Вы уверены, что хотите удалить данную услугу?"
               class="btn btn-danger">
                {{ trans('interactions.delete') }}
            </a>
            <a href="{{ route('cc.services.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            <a href="{{ route('service.show', [$formData['service']->alias]) }}" class="btn btn-info" target="_blank">
                {{ trans('interactions.show_on_site') }}
            </a>
        </div>

    {!! Form::close() !!}
@stop
