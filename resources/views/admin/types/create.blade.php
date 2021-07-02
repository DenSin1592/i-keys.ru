@extends('admin.categories.inner')

@section('title', 'Создание типа товаров')

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($formData['type'], $errors, ['url' => route('cc.types.store', [$formData['type']->id]), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}

    @include('admin.types._form_fields')

    {!! Form::hidden('position', $formData['type']->position) !!}

    <div class="action-bar">
        <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
        <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>

        <a href="{{ route('cc.types.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
        @if ($formData['type']->in_tree_publish)
        <!-- todo: site url -->
        @endif
    </div>

    {!! Form::close() !!}
@stop
