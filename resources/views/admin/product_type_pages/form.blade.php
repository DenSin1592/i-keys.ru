@extends('admin.layouts.default')
{{-- Layout for user forms --}}

@section('main_menu_class', 'closed')

@section('second_column')
    {!! HTML::additionalMenuOpen(['resize' => 'product-type-page']) !!}
    <div class="menu-wrapper">
        <div class="menu-header"><a href="{{ route('cc.product-type-pages.index') }}">Типы товаров</a></div>
        @include('admin.product_type_pages._pages_list_menu', ['productTypePageTree' => $productTypePageTree, 'lvl' => 0, 'currentPage' => $productTypePage])
        <div class="menu-footer">
            <a href="{{ route('cc.product-type-pages.create') }}" class="btn btn-success btn-xs">Добавить страницу</a>
        </div>
    </div>
    {!! HTML::additionalMenuClose() !!}
@stop

@section('content')
    @include('admin.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs])
    {!! Form::tbRestfulFormOpen($productTypePage, $errors, 'cc.product-type-pages', ['id' => 'product-type-page-form']) !!}

    {!! Form::tbFormGroupOpen('parent_id') !!}
        {!! Form::tbLabel('parent_id', trans('validation.attributes.parent_id')) !!}
        {!! Form::tbSelect2('parent_id', $parentVariants) !!}
    {!! Form::tbFormGroupClose() !!}

    {!! Form::tbTextBlock('name') !!}
    {!! Form::tbTextBlock('alias') !!}
    {!! Form::tbCheckboxBlock('publish') !!}
    {!! Form::hidden('position') !!}

    @include('admin.shared._header_meta_field')

    {!! Form::tbTinymceTextareaBlock('content_for_links_type') !!}
    {!! Form::tbTinymceTextareaBlock('content') !!}
    {!! Form::tbTinymceTextareaBlock('bottom_content') !!}

    {!! Form::tbFormGroupOpen('category_id') !!}
    {!! Form::tbLabel('category_id', trans('validation.attributes.filter_category_id')) !!}
    {!! Form::tbSelect2('category_id', $categoryVariants) !!}
    {!! Form::tbFormGroupClose() !!}

    @include('admin.product_type_pages.products._products')

    @include('admin.shared._form_meta_fields')

    @include('admin.shared._model_timestamps', ['model' => $productTypePage])

    <div class="action-bar">
        @yield('submit_block')
    </div>

    {!! Form::close() !!}
@stop
