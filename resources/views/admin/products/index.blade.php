@extends('admin.categories.inner')

@section('title')
    {{ $category->name }} - список товаров
@stop

@section('content')
    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div class="element-list-wrapper" data-sortable-wrapper="">
        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.attributes.name') }}</div>
            <div class="publish-status">{{ trans('validation.attributes.publish') }}</div>
            <div class="alias">{{ trans('validation.attributes.alias') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.products._product_list', ['productList' => $productList, 'lvl' => 0])
            @include('admin.shared._pagination_links', ['paginator' => $productList])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.products.update-positions', $category->id), 'reloadUrl' => route('cc.products.index', $category->id)])
    </div>
@stop
