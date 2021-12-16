@extends('client.layouts.default')

@section('body_class')
    class='product-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-product section-gray">

            @include('client.product._product_info')

            @include('client.product._main_characteristics')

            @include('client.product._expert')

        </section>
    </main>
@stop
