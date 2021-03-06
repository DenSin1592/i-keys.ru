@extends('client.layouts.default')

@section('body_class')
    class='catalog-page d-flex flex-column'
@endsection

@section('content')
    <main class="main-box flex-shrink-0 flex-grow-1">
        @include('client.categories._section_display')

        <section class="section-catalog">
            <div class="container">
                <div class="row">

                    <div class="catalog-aside-container col-lg-3" >
                        @if(!empty($filter['filterVariants']))
                            <button type="button" class="filter-toggle btn d-block d-lg-none text-center" >
                                <svg class="filter-toggle-media" width="24" height="24">
                                    <use xlink:href="{{asset('/images/client/sprite.svg#icon-filter')}}"></use>
                                </svg>
                                Фильтр
                            </button>

                            <div class="filter-block" id="filter">
                                @include('client.categories._filter_block')
                            </div>
                        @endif
                    </div>

                    <div class="catalog-content-container col-lg-9" id="category-content">
                        @include('client.categories._category_content')
                    </div>

                </div>
            </div>
        </section>


        @isset($services)
            @include('client.shared._section_services', [
                'services' => $services,
                'additionalClass' => ''
            ])
        @endisset

    </main>
@stop
