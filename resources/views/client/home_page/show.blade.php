@extends('client.layouts.default')


@section('body_class')
    class='home-page d-flex flex-column'
@endsection


@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">

        @include('client.home_page._section_intro')
        @include('client.home_page._section_service')
        @include('client.home_page._section_smartphone')
        @include('client.home_page._section_services')
        @include('client.home_page._section_about')
        @include('client.home_page._section_avito')
        @include('client.home_page._section_mojet_ya_sam')
        @include('client.home_page._section_steps')
        @include('client.home_page._section_faq')
        @include('client.home_page._section_cases')

    </main>
@endsection
