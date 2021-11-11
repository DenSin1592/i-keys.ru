@extends('admin.layouts.default')

@section('title')
    Создание
@stop

@section('content')

    {!! Form::tbRestfulFormOpen($formData['entity'], $errors, 'cc.subdomains', ['id' => 'entity']) !!}

    @include('admin.subdomains.form')

    <div class="action-bar">
        <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
        <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
        <a href="{{ route('cc.subdomains.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
    </div>

    {!! Form::close() !!}

@stop
