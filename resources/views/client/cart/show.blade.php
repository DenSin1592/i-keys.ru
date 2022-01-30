@extends('client.layouts.default')


@section('body_class')
    class='cart-page d-flex flex-column'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-display section-dark">
            <div class="container">
                @include('client.shared.breadcrumbs._breadcrumbs')
                <h1 class="display-title title-h1 text-uppercase">{{ $metaData['h1'] }}</h1>

                @include('client.cart._summary_block')

            </div>
        </section>

        @include('client.cart._section_items')

        @include('client.cart._section_form')

    </main>
@endsection

@section('modals')
    @include('client.shared.modal._fast_order')
    @include('client.shared.modal._remove_in_cart')
    @if (\Request::route()->getName() === "cart.show")
        @include('client.shared.modal._cdek_cart_popup')
    @endif
@endsection

