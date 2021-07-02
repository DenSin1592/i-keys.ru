@extends('admin.categories.inner')

@section('title')
    {{ $category->name }} - список параметров
@stop

@section('content')
    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    <div class="element-list-wrapper" data-sortable-wrapper="">
        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.attributes.name') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.attributes._attribute_list', ['attributeList' => $attributeList, 'lvl' => 0])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.attributes.update-positions'), 'reloadUrl' => route('cc.attributes.index', $category->id)])

        <div>
            <a href="{{ route('cc.attributes.create', $category->id) }}" class="btn btn-success btn-xs">Добавить параметр</a>
        </div>
    </div>
@stop
