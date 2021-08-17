@extends('admin.layouts.default')

@section('main_menu_class', 'closed')

@section('second_column')
    {!! Html::additionalMenuOpen(['resize' => 'categories']) !!}
    <div class="menu-wrapper">
        <div class="menu-header">
            <a href="{{ route('cc.categories.index') }}">Категории</a>
        </div>

        @include('admin.categories._category_list_menu', ['categoryTree' => $categoryTree, 'lvl' => 0, 'currentCategory' => isset($formData['category']) ? $formData['category'] : null])

        <div class="menu-footer">
            <a href="{{ route('cc.categories.create') }}" class="btn btn-success btn-xs">Добавить категорию</a>
        </div>
    </div>
    {!! Html::additionalMenuClose() !!}
@stop
