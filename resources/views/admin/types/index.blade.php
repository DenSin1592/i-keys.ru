@extends('admin.layouts.default')

@section('title', 'Категории товаров')

@section('content')
    @if (isset($breadcrumbs))
        @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endif
    <div class="element-list-wrapper category-list" data-sortable-wrapper="">
        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.attributes.name') }}</div>
            <div class="publish-status">{{ trans('validation.attributes.publish') }}</div>
            <div class="alias">{{ trans('validation.attributes.alias') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.types._type_list', ['typeTree' => $typeTree, 'lvl' => 0])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.types.update-positions'), 'reloadUrl' => empty($type) ? route('cc.types.index') : route('cc.types.show', $type->id)])

        <div>
            <a href="{{ route('cc.types.create', !empty($type) ? $type->id : null) }}" class="btn btn-success btn-xs">Добавить тип</a>
        </div>
    </div>
@stop
