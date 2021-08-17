@extends('admin.products.inner')

@section('title')
    {{ $product->category->name }} | {{ $product->name }} - редактирование товара
@stop

@section('content')

    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])

    {!! Form::tbModelWithErrors($product, $errors, ['url' => route('cc.products.update', [$product->category->id, $product->id]), 'method' => 'put', 'files' => true, 'autocomplete' => 'off']) !!}

        @include('admin.products._form_fields')

        {!! Form::hidden('position', $product->position) !!}

        <div class="action-bar">
            <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
            <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
            @include('admin.products._delete_product', ['product' => $product])
            <a href="{{ route('cc.products.index', $product->category->id) }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
            @if ($product->publish && $product->category->in_tree_publish)
                @include('admin.shared._show_on_site_button', ['url' => \CatalogUrlBuilder::getUrl($product)])
            @endif
        </div>

    {!! Form::close() !!}
@stop
