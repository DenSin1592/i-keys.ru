@extends('admin.layouts.default')

@section('title', 'Заказы')

@section('content')
    <div id="order-list" class="element-list-wrapper">
        <div class="element-container header-container">
            <div class="id">{{ trans('validation.attributes.id') }}</div>
            <div class="status">{{ trans('validation.attributes.status') }}</div>
            <div class="type">{{ trans('validation.attributes.type') }}</div>
            <div class="payment_status">{{ trans('validation.attributes.payment_status') }}</div>
            @include('admin.shared.device_type._list_column_header')
            <div class="name">{{ trans('validation.attributes.full_name') }}</div>
            <div class="phone">{{ trans('validation.attributes.phone') }}</div>
            <div class="created_at">{{ trans('validation.attributes.created_at') }}</div>
            <div class="control">{{ trans('interactions.controls') }}</div>
        </div>

        <div>
            @include('admin.orders._order_list', ['orderList' => $orderList])
            @include('admin.shared._pagination_links', ['paginator' => $orderList])
        </div>

        <div>
            <a href="{{ route('cc.orders.create') }}" class="btn btn-success btn-xs">Добавить заказ</a>
        </div>
    </div>
@stop
