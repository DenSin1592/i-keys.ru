@extends('admin.layouts.default')

@section('title', 'Каталоги')

@section('content')
    @if (isset($breadcrumbs))
        @include('admin.shared._catalog_breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    @endif

    @include('admin.categories._category_list_wrapper')
@stop
