@extends('admin.layouts.default')

@section('title')
    {{ 'Типы товаров' }}
@stop

@section('content')
    <div id="product-type-page-list" class="element-list-wrapper" data-sortable-wrapper="">
        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.attributes.name') }}</div>
            <div class="publish-status">{{ trans('validation.attributes.publish') }}</div>
            <div class="alias">{{ trans('validation.attributes.alias') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.product_type_pages._pages_list', ['productTypePageTree' => $productTypePageTree, 'lvl' => 0])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.product-type-pages.update-positions'), 'reloadUrl' => route('cc.product-type-pages.index')])

        <div>
            <a href="{{ route('cc.product-type-pages.create') }}" class="btn btn-success btn-xs">Добавить страницу</a>
        </div>
    </div>
@stop
