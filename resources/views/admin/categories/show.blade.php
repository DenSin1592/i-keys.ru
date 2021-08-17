@extends('admin.layouts.default')

@section('title', "Категория \"{$category->name}\"")

@section('content')
    @if (isset($breadcrumbs))
        @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs, 'category' => $category])
    @endif

<div class="category scrollable-container">
    <strong id="subcategories">Подкатегории для категории "{{ $category->name }}"</strong>
    @include('admin.categories._category_list_wrapper', ['categoryTree' => $categoryTree, 'disableScrollable' => true])

    <hr>
</div>
@stop
