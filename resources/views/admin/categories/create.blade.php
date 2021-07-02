@extends('admin.categories.inner')

@section('title', 'Создание категории')

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($formData['category'], $errors, ['url' => route('cc.categories.store'), 'method' => 'post', 'files' => true]) !!}

        @include('admin.categories._form_fields')

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.create') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.create_and_back_to_list') }}</button>

            @if ($formData['parent'])
                <a href="{{ route('cc.categories.show', $formData['parent']->id) }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @else
                <a href="{{ route('cc.categories.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @endif
        </div>

    {!! Form::close() !!}
@stop
