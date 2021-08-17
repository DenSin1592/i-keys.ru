@extends('admin.products.inner')

@section('title')
    {{ $product->category->name }} | Создание товара
@stop

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($product, $errors, ['url' => route('cc.products.store', $product->category->id), 'method' => 'post', 'files' => true, 'autocomplete' => 'off']) !!}
        @include('admin.products._form_fields')

        {!! Form::hidden('position', $product->position) !!}

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.create') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.create_and_back_to_list') }}</button>
            <a href="{{ route('cc.products.index', $product->category->id) }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
        </div>

    {!! Form::close() !!}
@stop
