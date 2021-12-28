@extends('admin.attributes.inner')

@section('title')
    Создание услуги
@stop

@section('content')

    {!! Form::tbModelWithErrors($formData['service'], $errors, ['url' => route('cc.services.store'), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}

        @include('admin.services._form_fields')

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.create') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.create_and_back_to_list') }}</button>
            <a href="{{ route('cc.services.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
        </div>

    {!! Form::close() !!}
@stop
