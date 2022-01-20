@extends('admin.layouts.default')

@section('title')
    Список услуг
@stop

@section('content')

    <div class="attribute-list element-list-wrapper" data-sortable-wrapper="">

        <div class="element-container header-container">
            @include('admin.shared.resource_list.sorting._list_header')
            <div class="name">{{ trans('validation.services.name') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div data-sortable-container="">
            @include('admin.services._services_list', ['serviceList' => $serviceList, 'lvl' => 0])
        </div>

        @include('admin.shared.resource_list.sorting._commit', ['updateUrl' => route('cc.services.update-positions'), 'reloadUrl' => route('cc.services.index')])

        <div>
            <a href="{{ route('cc.services.create') }}" class="btn btn-success btn-xs">Добавить услугу</a>
            <div class="total-count"><strong>Общее число услуг</strong>: <div>{{ count($serviceList) }}</div></div>
        </div>
    </div>
@stop
