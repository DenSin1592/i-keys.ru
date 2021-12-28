@extends('client.layouts.default')


@section('body_class')
    class='services-page d-flex flex-column'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">
        {!! $service->content !!}
    </main>
@endsection

@section('modals')

@endsection
