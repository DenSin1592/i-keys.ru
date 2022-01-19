@extends('client.layouts.default')


@section('body_class')

@endsection


@section('content')
    @include('client.shared.breadcrumbs._breadcrumbs')

    search page

    <br/>
    <br/>

    @foreach($productsData as $productData)
    {{$productData['product']->name}}
        <br/>
        <br/>
    @endforeach
@endsection
