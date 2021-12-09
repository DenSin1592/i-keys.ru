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
                <div class="display-subtitle title-h4">
                    В корзине {{\Cart::totalCount() . ' ' . \Lang::choice('товар|товара|товаров', \Cart::totalCount())}}
                    ,{{-- 2 услуги--}}
                    на сумму {{\Cart::totalPrice()}} р.
                </div>
            </div>
        </section>

        @include('client.cart._section_items')

        @include('client.cart._section_form')

    </main>
@endsection

@section('modals')

    @include('client.shared.modal._fast_order')

@endsection

