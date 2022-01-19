@extends('client.layouts.default')


@section('body_class')
    class='search-page d-flex flex-column section-gray'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        <section class="section-display section-dark" >
            <div class="container">
                @include('client.shared.breadcrumbs._breadcrumbs')
            </div>
        </section>
    </main>




    search page

    <br/>
    <br/>

    @foreach($productsData as $productData)
    {{$productData['product']->name}}
        <br/>
        <br/>
    @endforeach
@endsection
