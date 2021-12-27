@extends('admin.layouts.default')

@section('title', 'Серии')

@section('content')
    @if (isset($breadcrumbs))
        @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endif
    <div class="element-list-wrapper review-list">
        <div class="element-container header-container">
            <div class="id">{{ trans('validation.attributes.id') }}</div>
            <div class="name">{{ trans('validation.attributes.review_name') }}</div>
            <div class="type">{{ trans('validation.attributes.type') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div>
            @include('admin.products_series._element_list')
            @include('admin.shared._pagination_links', ['paginator' => $modelList])
        </div>

        <div>
            <a href="{{ route('cc.products-series.create') }}" class="btn btn-success btn-xs">Добавить серию</a>
        </div>
    </div>
@stop
