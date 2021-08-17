@extends('admin.layouts.default')

@section('main_menu_class', 'closed')

@section('second_column')
    {!! HTML::additionalMenuOpen(['resize' => 'products']) !!}
        <div class="menu-wrapper">
            <div class="menu-header"><a href="{{ route('cc.products.index', [$category->id]) }}">{{ $category->name }}</a></div>
            @include('admin.products._product_list_menu', ['productList' => $productList, 'lvl' => 0, 'currentProduct' => isset($product) ? $product : null])
            @include('admin.shared._pagination_simple_links', ['paginator' => $productList])
            <div class="menu-footer">
                <a href="{{ route('cc.products.create', $category->id) }}" class="btn btn-success btn-xs">Добавить товар</a>
            </div>
        </div>
    {!! HTML::additionalMenuClose() !!}
@stop
