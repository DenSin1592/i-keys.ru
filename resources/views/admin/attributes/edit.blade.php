@extends('admin.attributes.inner')

@section('title')
    {{ $formData['attribute']->name }} - редактирование параметра
@stop

@section('content')

    {!! Form::tbModelWithErrors($formData['attribute'], $errors, ['url' => route('cc.attributes.update', [$formData['attribute']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']) !!}

        @include('admin.attributes._form_fields')

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.create_and_back_to_list') }}</button>
            <a href="{{ route('cc.attributes.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
        </div>

    {!! Form::close() !!}
@stop
