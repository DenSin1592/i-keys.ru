@extends('admin.layouts.default')

@section('title')
    {{ 'Структура сайта' }}
@stop

@section('content')
    <div class="node-list element-list-wrapper" data-sortable-wrapper="">
        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.attributes.name') }}</div>
            <div class="publish-status">{{ trans('validation.attributes.publish') }}</div>
            <div class="menu_top-status">{{ trans('validation.attributes.menu_top') }}</div>
            <div class="menu_bottom-status">{{ trans('validation.attributes.menu_bottom') }}</div>
            <div class="alias">{{ trans('validation.attributes.alias') }}</div>
            <div class="type">{{ trans('validation.attributes.type') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.structure._node_list', ['nodeTree' => $nodeTree, 'lvl' => 0])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.structure.update-positions'), 'reloadUrl' => route('cc.structure.index')])

        <div>
            <a href="{{ route('cc.structure.create') }}" class="btn btn-success btn-xs">Добавить страницу</a>
        </div>
    </div>
@stop
