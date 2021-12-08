@extends('emails.layouts.default')

@section('content')

    <p style="color: #0045b0;">Уважаемый(-ая) {!! $order->name !!}!</p>
    <p>Ваш заказ принят к рассмотрению.</p>
    <p style="color: #0045b0;">Пожалуйста, внимательно ознакомьтесь с информацией о заказе.</p>
    <p>Номер заказа: {{ $order->id }} от {!! Helper::outDatetime($order->created_at) !!}.</p>

    @include('emails.order.shared._order_info')
@endsection