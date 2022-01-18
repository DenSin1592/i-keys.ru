@extends('admin.layouts.default')
{{-- Layout for user forms --}}

@section('main_menu_class', 'closed')

@section('second_column')
    {!! Html::additionalMenuOpen(['resize' => 'orders']) !!}
    <div class="menu-wrapper">
        <div class="menu-header">
            <a href="{{ route('cc.orders.index') }}">Заказы</a>
        </div>

        <ul class="scrollable-container">
            @foreach ($orderList as $order)
                <li>
                    <div class="menu-element {{ $formData['order']->id == $order->id ? 'active' : '' }}">
                        <div class="name">
                            <a href="{{ route('cc.orders.edit', [$order->id]) }}"
                               title="{{ $order->name ?? '-' }}">{!! $order->name ?? '<i>не указано</i>' !!}</a>
                        </div>
                        <div class="control">
                            @include('admin.orders._list_controls', ['order' => $order])
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>

        @include('admin.shared._pagination_simple_links', ['paginator' => $orderList])

        <div class="menu-footer">
            <a href="{{ route('cc.orders.create') }}" class="btn btn-success btn-xs">Добавить заказ</a>
        </div>
    </div>
    {!! Html::additionalMenuClose() !!}
@stop

@section('content')

    {!! Form::tbRestfulFormOpen($formData['order'], $errors, 'cc.orders', ['id' => 'order-form']) !!}

        @if ($formData['order']->exists)
        {!! Form::tbFormGroupOpen('id') !!}
            <strong>{!! trans('validation.attributes.id') !!}</strong>: {!! $formData['order']->id !!}
        {!! Form::tbFormGroupClose() !!}
        @endif

        {!! Form::tbSelectBlock('exchange_status', $formData['exchange_status_variants']) !!}
        @include('admin.shared.device_type._form_field', ['model' => $formData['order']])

        @if (!is_null($formData['order']->client))
        {!! Form::tbFormGroupOpen('client_id') !!}
            {!! Form::hidden('client_id') !!}
            <strong>{{ trans("validation.attributes.client") }}</strong>:
            <a target="_blank" href="{{ route('cc.client-users.edit', [$formData['order']->client->id]) }}">{{ $formData['order']->client->name }}</a>
        {!! Form::tbFormGroupClose() !!}
        @endif
        {!! Form::tbTextBlock('name', trans('validation.attributes.full_name')) !!}
        {!! Form::tbSelectBlock('status', $formData['status_variants']) !!}
        {!! Form::tbSelectBlock('type', $formData['type_variants']) !!}

        <div class="form-group">
            <label for="phone" class="control-label">Телефон</label>
            <input data-phone class="form-control" name="phone" type="text" id="phone" required>
        </div>
        {!! Form::tbTextBlock('email') !!}
        {!! Form::tbSelectBlock('payment_status', $formData['payment_status_variants']) !!}
        {!! Form::tbSelectBlock('payment_method', $formData['payment_method_variants']) !!}

        {!! Form::tbSelectBlock('delivery_method', $formData['delivery_method_variants'], null, null, ['data-with-address' => json_encode(\App\Models\Order\DeliveryMethodConstants::withDeliveryAddress())]) !!}

        <fieldset id="delivery-address" class="bordered-group">
            <legend>Адрес доставки</legend>
{{--            {!! Form::tbTextBlock('postcode') !!}--}}
{{--            {!! Form::tbSelect2Block('region_id', $formData['region_variants']) !!}--}}
            {!! Form::tbTextBlock('city') !!}
            {!! Form::tbTextBlock('street') !!}
            {!! Form::tbTextBlock('building') !!}
            {!! Form::tbTextBlock('flat') !!}
        </fieldset>
        {!! Form::tbTextareaBlock('comment') !!}

       @include('admin.orders.form._model_document_field', ['model' =>  $formData['order'], 'field' => 'document'])
       @include('admin.orders.form.order_items._field', [
           'order' => $formData['order'],
           'orderItems' => $formData['orderItems'],
           'totalPrice' => $formData['totalPrice'],
       ])

       @include('admin.shared._model_timestamps', ['model' => $formData['order']])

       <div class="action-bar">
           @yield('submit_block')
       </div>

   {!! Form::close() !!}

@stop
