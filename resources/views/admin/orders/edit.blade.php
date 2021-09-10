@extends('admin.orders.form', ['formData' => $formData, 'orderList' => $orderList])

@section('title')
    {{ $formData['order']->name }} - редактирование
@stop

@section('submit_block')
    <button type="submit" class="btn btn-success">{{ trans('interactions.save') }}</button>
    <button type="submit" class="btn btn-primary" name="redirect_to" value="index">{{ trans('interactions.save_and_back_to_list') }}</button>
    @include('admin.orders._delete_order', ['order' => $formData['order']])
    <a href="{{ route('cc.orders.index') }}" class="btn btn-default">{{ trans('interactions.back_to_list') }}</a>
@stop
