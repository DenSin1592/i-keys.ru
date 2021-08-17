@extends('admin.product_type_pages.form')

@section('title')
    Создание страницы типа товаров
@stop

@section('submit_block')
    <button type="submit" class="btn btn-success">{{ trans('interactions.create') }}</button>
    <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.create_and_back_to_list') }}</button>
    <a href="{{ route('cc.product-type-pages.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
@stop
