@extends('admin.product_type_pages.form')

@section('title')
    {{ $productTypePage->name }} - редактирование
@stop

@section('submit_block')
    <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
    <button type="submit" class="btn btn-primary" name="redirect_to"
            value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
    <a class="btn btn-danger" data-method="delete"
       data-confirm="Вы уверены, что хотите удалить данную страницу типа товаров?"
       href="{{ route('cc.product-type-pages.destroy', $productTypePage->id) }}">{{ trans('interactions.delete') }}</a>
    <a href="{{ route('cc.product-type-pages.index') }}"
       class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
    @if ($productTypePage->publish)
        @include('admin.shared._show_on_site_button', ['url' => UrlBuilder::getUrl($productTypePage)])
    @endif
@stop
