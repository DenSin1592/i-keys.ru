@extends('emails.layouts.default')

@section('content')
    <p>Поступил новый заказ c сайта <a href="{{ route('home') }}">{!! Request::getHost() !!}</a>.</p>

    <p>Номер заказа: <span style="font-weight: bold;">{{ $order->id }}</span> от <span style="font-weight: bold;">{!! Helper::outDatetime($order->created_at) !!}</span>.</p>

    <p>Чтобы его просмотреть и/или отредактировать, пожалуйста, перейдите по <a
                href="{{ route('cc.orders.edit', [$order->id]) }}">ссылке</a>.</p>

    @include('emails.order.shared._order_info')
@endsection