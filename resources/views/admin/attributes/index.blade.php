@extends('admin.layouts.default')

@section('title')
    Список параметров
@stop

@section('content')

    <div class="attribute-list element-list-wrapper" data-sortable-wrapper="">

        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.attributes.name') }}</div>
            <div class="attribute_type">{{ trans('validation.attributes.attribute_type') }}</div>
            <div class="use_in_filter-status">{{ trans('validation.attributes.use_in_filter') }}</div>
            <div class="for_admin_filter-status">{{ trans('validation.attributes.for_admin_filter') }}</div>
            <div class="hidden-status">{{ trans('validation.model_attributes.attribute.hidden') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.attributes._attribute_list', ['attributeList' => $attributeList, 'lvl' => 0])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.attributes.update-positions'), 'reloadUrl' => route('cc.attributes.index')])

        <div>
            <a href="{{ route('cc.attributes.create') }}" class="btn btn-success btn-xs">Добавить параметр</a>
            <div class="total-count"><strong>Общее число параметров</strong>: <div>{{ count($attributeList) }}</div></div>
        </div>
    </div>
@stop
