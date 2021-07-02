@extends('admin.categories.inner')

@section('title')
    {{ $formData['type']->name }} - редактирование
@stop

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($formData['type'], $errors, ['url' => route('cc.types.update', [$formData['type']->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']) !!}

    @include('admin.types._form_fields')

    {!! Form::hidden('position', $formData['type']->position) !!}

    <div class="action-bar">
        <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
        <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
        @include('admin.types._delete_type', ['type' => $formData['type']])
        <a href="{{ route('cc.types.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
        @if ($formData['type']->in_tree_publish)
        <!-- todo: site url -->
        @endif
    </div>

    {!! Form::close() !!}
@stop
