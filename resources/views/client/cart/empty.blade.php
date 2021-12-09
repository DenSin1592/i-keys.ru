@extends('client.layouts.default')

@section('body_class')
    class='cart-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-display section-dark" >
            <div class="container">

                @include('client.shared.breadcrumbs._breadcrumbs')

                <h1 class="display-title title-h1 text-uppercase">{{ $metaData['h1'] }}</h1>
                <div class="display-subtitle title-h4">
                    <p class="title-h2 mb-2" >Ваша корзина пуста.</p>
                    <p>Для оформления заказа добавьте в корзину как минимум один товар. Если хотите что-либо приобрести, {!! link_to(route('catalog', 'zamki'), 'перейдите в каталог') !!}. </p>
                </div>
            </div>
        </section>

    </main>
@endsection
