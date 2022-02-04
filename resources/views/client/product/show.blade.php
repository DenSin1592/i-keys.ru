@extends('client.layouts.default')

@section('body_class')
    class='product-page d-flex flex-column'
@endsection

@section('content')
  @include('client.product._inner_show')
@stop

@section('modals')
    @include('client.shared.modal._add_keys')
@stop
